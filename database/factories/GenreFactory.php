<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Genre>
 */
class GenreFactory extends Factory
{
    protected $model = Genre::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'parent_id' => null,
            'description' => $this->faker->paragraph(),
            'book_count' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
