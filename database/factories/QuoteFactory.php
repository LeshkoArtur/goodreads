<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
    protected $model = Quote::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'text' => $this->faker->sentence(),
            'page_number' => $this->faker->numberBetween(1, 500),
            'contains_spoilers' => $this->faker->boolean(),
            'is_public' => $this->faker->boolean(),
        ];
    }
}
