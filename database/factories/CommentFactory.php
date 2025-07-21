<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use App\Models\GroupPost;
use App\Models\Quote;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'commentable_id' => fake()->uuid(),
            'commentable_type' => fake()->randomElement([
                'Post', 'GroupPost', 'Quote'
            ]),
            'content' => fake()->paragraph(),
        ];
    }
}
