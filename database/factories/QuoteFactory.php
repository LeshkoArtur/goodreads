<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteFactory extends Factory
{
    protected $model = Quote::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'text' => fake()->paragraph(),
            'page' => fake()->numberBetween(1, 400),
        ];
    }
}
