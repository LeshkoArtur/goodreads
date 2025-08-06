<?php

namespace Database\Factories;

use App\Enums\AnswerStatus;
use App\Models\Author;
use App\Models\AuthorAnswer;
use App\Models\AuthorQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AuthorAnswer>
 */
class AuthorAnswerFactory extends Factory
{
    protected $model = AuthorAnswer::class;

    public function definition(): array
    {
        return [
            'question_id' => AuthorQuestion::factory(),
            'author_id' => Author::factory(),
            'content' => $this->faker->paragraph(),
            'published_at' => $this->faker->dateTimeThisYear(),
            'answer_status' => $this->faker->randomElement(AnswerStatus::cases()),
        ];
    }
}
