<?php

namespace Database\Factories;

use App\Models\BookSeries;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookSeriesFactory extends Factory
{
    protected $model = BookSeries::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'total_books' => $this->faker->numberBetween(0, 20),
            'is_completed' => $this->faker->boolean(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
