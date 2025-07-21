<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Character;
use Illuminate\Database\Eloquent\Factories\Factory;

class CharacterFactory extends Factory
{
    protected $model = Character::class;

    public function definition(): array
    {
        return [
            'book_id' => Book::factory(),
            'name' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
        ];
    }
}
