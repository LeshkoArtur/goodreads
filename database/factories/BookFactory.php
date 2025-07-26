<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(2),
            'description' => fake()->paragraph(),

            'page_count' => fake()->numberBetween(100, 500),
            'language' => fake()->languageCode(),
            'cover_url' => fake()->imageUrl(),
            'isbn' => fake()->isbn13(),
        ];
    }
}
