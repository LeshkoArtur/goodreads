<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\ReadingStat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReadingStatFactory extends Factory
{
    protected $model = ReadingStat::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'pages_read' => $this->faker->numberBetween(1, 500),
            'completed' => $this->faker->boolean(),
        ];
    }
}
