<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'environment:modify {key : Key name} {value : New value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permanently modifies an environment variable on the .env file for later use.';

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
     * @return mixed
     */
    public function handle()
    {
      $path = base_path('/.env');
      $key = $this->argument('key');

      $value = $this->argument('value');
      $originalValue = env($key);

      if (is_null($originalValue))
      {
         // Attempt to silently fix issue
         $this->callSilent('cache:clear');
         $originalValue = env($key);

         // Still fails? Let the user know
         if (is_null($originalValue))
         {
           $this->error('[!!] Cannot update requested configuration value! This is a known Laravel issue. If you report a bug, keep that in mind.');

           return false;
         }
      }

      if (file_exists($path))
      {
          $file = file_get_contents($path);
          $newConfig = str_replace($key . '=' . $originalValue, $key . '=' . $value, $file);

          file_put_contents(
            $path,
            $newConfig
          );

      }
      else
      {
        $this->error('Cannot update a file that doesn\'t exist! Please create .env first.');
        return false;
      }


      $this->info('>> Changed value! It may now be accessed via env() or config() if there\'s a file for it.');
    }
}
