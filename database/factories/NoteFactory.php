<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    protected $model = Note::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'content' => $this->faker->paragraph(),
            'page' => $this->faker->numberBetween(1, 400),
        ];
    }
}
