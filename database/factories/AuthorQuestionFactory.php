<?php

namespace Database\Factories;

use App\Enums\QuestionStatus;
use App\Models\Author;
use App\Models\AuthorQuestion;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AuthorQuestion>
 */
class AuthorQuestionFactory extends Factory
{
    protected $model = AuthorQuestion::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'author_id' => Author::factory(),
            'book_id' => Book::factory(),
            'content' => $this->faker->sentence(),
            'question_status' => $this->faker->randomElement(QuestionStatus::cases()),
        ];
    }
}
