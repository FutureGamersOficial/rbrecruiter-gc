<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GeoSot\EnvEditor\Facades\EnvEditor;

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



      if (file_exists($path))
      {
          EnvEditor::editKey($key, $value);
      }
      else
      {
        $this->error('Cannot update a file that doesn\'t exist! Please create .env first.');
        return false;
      }
    }
}
