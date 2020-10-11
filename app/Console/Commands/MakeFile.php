<?php

namespace App\Console\Commands;

use Faker\Factory;
use Faker\Generator;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
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
        $this->info('Creating ' . $this->argument('count') . ' files!');

        for ($max = 1; $max < $count; $max++)
        {
            Storage::disk('local')->put('factory_files/testfile_' . rand(0, 5000) . '.txt', $this->faker->paragraphs(40, true));

        }

        $this->info('Finished creating files! They will be randomly picked by the factory.');
        return 0;
    }
}
