<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\GroupPost;
use App\Models\Post;
use App\Models\Quote;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        $commentableTypes = [
            Post::class => Post::factory(),
            GroupPost::class => GroupPost::factory(),
            Quote::class => Quote::factory(),
            Rating::class => Rating::factory(),
        ];

        $commentableType = $this->faker->randomElement(array_keys($commentableTypes));
        $commentableFactory = $commentableTypes[$commentableType];

        return [
            'user_id' => User::factory(),
            'commentable_type' => $commentableType,
            'commentable_id' => $commentableFactory,
            'content' => $this->faker->paragraph(),
            'parent_id' => null,
        ];
    }
}
