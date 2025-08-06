<?php

namespace Database\Factories;

use App\Models\GroupPost;
use App\Models\Like;
use App\Models\Post;
use App\Models\Quote;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    protected $model = Like::class;

    public function definition(): array
    {
        $likeableTypes = [
            Post::class => Post::factory(),
            GroupPost::class => GroupPost::factory(),
            Quote::class => Quote::factory(),
            Rating::class => Rating::factory(),
        ];

        $likeableType = $this->faker->randomElement(array_keys($likeableTypes));
        $likeableFactory = $likeableTypes[$likeableType];

        return [
            'user_id' => User::factory(),
            'likeable_type' => $likeableType,
            'likeable_id' => $likeableFactory,
        ];
    }
}
