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

namespace Database\Factories;

use App\TeamFile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class TeamFileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TeamFile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $prefix = Storage::disk('local')->getAdapter()->getPathPrefix();

        return [
            'uploaded_by' => rand(1, 10), // Also assuming that the user seeder has ran before
            'team_id' => rand(1, 3), // Assuming you create 3 teams beforehand
            'name' => $this->faker->file($prefix.'factory_files', $prefix.'uploads', false),
            'caption' => $this->faker->sentence(),
            'description' => $this->faker->paragraphs(3, true),
            'fs_location' => $this->faker->file($prefix.'factory_files', $prefix.'uploads'),
            'extension' => 'txt',
            'size' => rand(1, 1000), // random fake size between 0 bytes and 1 mb
        ];
    }
}
