<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use App\Models\UserBook;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserBookFactory extends Factory
{
    protected $model = UserBook::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'status' => $this->faker->randomElement(['reading', 'completed', 'wishlist']),
            'started_reading' => $this->faker->optional()->date(),
            'finished_reading' => $this->faker->optional()->date(),
        ];
    }
}
