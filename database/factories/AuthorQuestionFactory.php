<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\AuthorQuestion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorQuestionFactory extends Factory
{
    protected $model = AuthorQuestion::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'author_id' => Author::factory(),
            'question' => $this->faker->sentence(),
        ];
    }
}
