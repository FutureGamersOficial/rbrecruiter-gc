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

use Faker\Factory;
use Faker\Generator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MakeFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:make {count : How many test files to generate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates test files for the TeamFile model. Use in conjunction with it\'s factory.';

    /**
     * The faker instance used to obtain dummy text.
     *
     * @var Generator
     */
    private $faker;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = Factory::create();

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $count = $this->argument('count');
        $this->info('Creating '.$this->argument('count').' files!');

        for ($max = 1; $max < $count; $max++) {
            Storage::disk('local')->put('factory_files/testfile_'.rand(0, 5000).'.txt', $this->faker->paragraphs(40, true));
        }

        $this->info('Finished creating files! They will be randomly picked by the factory.');

        return 0;
    }
}
