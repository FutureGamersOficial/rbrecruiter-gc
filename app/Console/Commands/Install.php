<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:install {-u|--unattended: Install non-interactively (currently unused: WIP)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs the application and prepares for production use.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $basePath = base_path();
        if (Storage::disk('local')->missing('INSTALLED'))
        {


           $this->info('[!! Welcome to Rasberry Teams !!]');
           $this->info('>> Installing...');
           $this->call('down', [
             '--message' => 'Down for maintenance. We\'ll be right back!'
           ]);

           copy($basePath . '/.env.example', $basePath . '/.env');
           $this->call('key:generate');

           $this->info('>> Installing and preparing dependencies. This may take a while, depending on your computer.');

           $npmOut = 0;
           $npmMessages = [];

           $npmBuildOut = 0;
           $npmBuildMessages = [];

           exec('cd ' . $basePath . ' && npm install --silent', $npmBuildOut, $npmOut);
           exec('cd ' . $basePath . '&& npm run dev --silent', $npmBuildMessages, $npmBuildOut);


           if($npmOut !== 0 && $npmBuildOut !== 0)
           {
             $this->error('[!] One or more errors have ocurred whilst attempting to install dependencies.');
             $this->error('[!] It is recommended to run this command again, and report a bug if it keeps happening.');

             return false;
           }



           $settings = [];

           $this->info('>> Configuring application - We\'re going to ask a few questions here!');
           do
           {
               $this->info('== Database Settings (1/6) ==');

               $settings['DB_USERNAME'] = $this->ask('Database username');
               $settings['DB_PASSWORD'] = $this->secret('Database password (Input won\'t be seen)');
               $settings['DB_DATABASE'] = $this->ask('Database name');
               $settings['DB_PORT'] = $this->ask('Database port');
               $settings['DB_HOST'] = $this->ask('Database hostname');

               $this->info('== Antispam Settings (2/6) (Recaptcha v2) ==');
               $settings['RECAPTCHA_SITE_KEY'] = $this->ask('Site key');
               $settings['RECAPTCHA_PRIVATE_KEY'] = $this->ask('Private site key');

               $this->info('== IP Geolocation Settings (3/6) (refer to README.md) ==');
               $settings['APIGEO_API_KEY'] = $this->ask('API Key');

               $this->info('== Notification Settings (4/6) (Email) ==');
               $settings['MAIL_USERNAME'] = $this->ask('SMTP Username');
               $settings['MAIL_PASSWORD'] = $this->secret('SMTP Password (Input won\'t be seen)');
               $settings['MAIL_PORT'] = $this->ask('SMTP Server Port');
               $settings['MAIL_HOST'] = $this->ask('SMTP Server Hostname');

               $this->info('== Notification Settings (5/6) (Slack) ==');
               $settings['SLACK_INTEGRATION_WEBHOOK'] = $this->ask('Integration webhook URL');

               $this->info('== Web Settings (6/6) ==');
               $settings['APP_URL'] = $this->ask('Application\'s URL');

           } while(!$this->confirm('Are you sure you want to save these settings? You can always go back and try again.'));

           foreach($settings as $keyname => $value)
           {
              $this->callSilent('environment:modify', [
                  'key' => $keyname,
                  'value' => $value
              ]);
           }

           $this->info('>> Saved configuration settings!');
           $this->info('>> Preparing database...');

           $this->call('migrate');
           $this->call('db:seed');

           touch($basePath . '/INSTALLED');

           $this->call('up');
           $this->info('>> All done! Visit ' . $baseURL . ' to start using your brand new installation of Raspberry Teams!');

        }
        else
        {
           $this->error('[!] The application is already installed!');
        }
    }
}
