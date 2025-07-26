<?php

namespace Database\Factories;

use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublisherFactory extends Factory
{
    protected $model = Publisher::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => fake()->company(),
            'country' => fake()->country(),
            'founded_year' => fake()->year(),
        ];
    }
}
