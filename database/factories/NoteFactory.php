<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    protected $model = Note::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'text' => $this->faker->paragraph(),
            'page_number' => $this->faker->numberBetween(1, 500),
            'contains_spoilers' => $this->faker->boolean(),
            'is_private' => $this->faker->boolean(),
        ];
    }
}
