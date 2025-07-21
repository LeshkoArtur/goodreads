<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\AuthorAnswer;
use App\Models\AuthorQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorAnswerFactory extends Factory
{
    protected $model = AuthorAnswer::class;

    public function definition(): array
    {
        return [
            'question_id' => AuthorQuestion::factory(),
            'author_id' => Author::factory(),
            'answer' => $this->faker->paragraph(),
        ];
    }
}
