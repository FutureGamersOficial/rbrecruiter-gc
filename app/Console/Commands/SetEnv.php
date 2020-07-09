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
     * @see https://stackoverflow.com/a/50965881/11540218
     * @return mixed
     */
    public function handle()
    {
      $path = base_path('/.env');
      $name = $this->argument('key');
      $value = $this->argument('value');

      if (file_exists($path))
      {
        file_put_contents($path, str_replace(
            $name . '=' . env($name), $name . '=' . $value, file_get_contents($path)
        ));
      }

      $this->info('>> Changed value! It may now be accessed via env() or config() if there\'s a file for it.');
    }
}
