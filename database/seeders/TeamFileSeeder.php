<?php

namespace Database\Seeders;

use App\TeamFile;
use Illuminate\Database\Seeder;

class TeamFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TeamFile::factory()->count(50)->create();
    }
}
