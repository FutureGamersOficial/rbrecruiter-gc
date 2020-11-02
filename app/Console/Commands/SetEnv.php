<?php

/*
 * Copyright © 2020 Miguel Nogueira
 *
 *   This file is part of Raspberry Staff Manager.
 *
 *     Raspberry Staff Manager is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     Raspberry Staff Manager is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with Raspberry Staff Manager.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\Console\Commands;

use GeoSot\EnvEditor\Facades\EnvEditor;
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

        if (file_exists($path)) {
            EnvEditor::editKey($key, $value);
        } else {
            $this->error('Cannot update a file that doesn\'t exist! Please create .env first.');

            return false;
        }
    }
}
