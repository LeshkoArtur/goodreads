<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenreFactory extends Factory
{
    protected $model = Genre::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => fake()->word(),
            'description' => fake()->sentence(),
        ];
    }
}
