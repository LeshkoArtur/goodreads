<?php

namespace Database\Factories;

use App\Models\BookSeries;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookSeries>
 */
class BookSeriesFactory extends Factory
{
    protected $model = BookSeries::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'total_books' => $this->faker->numberBetween(1, 20),
            'is_completed' => $this->faker->boolean(),
        ];
    }
}
