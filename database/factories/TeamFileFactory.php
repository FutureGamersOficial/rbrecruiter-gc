<?php

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
            'name' => $this->faker->file($prefix . 'factory_files', $prefix . 'uploads', false),
            'caption' => $this->faker->sentence(),
            'description' => $this->faker->paragraphs(3, true),
            'fs_location' => $this->faker->file($prefix . 'factory_files', $prefix . 'uploads'),
            'extension' => 'txt',
            'size' => rand(1, 1000) // random fake size between 0 bytes and 1 mb
        ];
    }
}
