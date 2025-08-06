<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Favorite;
use App\Models\GroupPost;
use App\Models\Post;
use App\Models\Quote;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Favorite>
 */
class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition(): array
    {
        $favoriteableTypes = [
            Book::class => Book::factory(),
            Post::class => Post::factory(),
            GroupPost::class => GroupPost::factory(),
            Quote::class => Quote::factory(),
            Rating::class => Rating::factory(),
        ];

        $favoriteableType = $this->faker->randomElement(array_keys($favoriteableTypes));
        $favoriteableFactory = $favoriteableTypes[$favoriteableType];

        return [
            'user_id' => User::factory(),
            'favoriteable_type' => $favoriteableType,
            'favoriteable_id' => $favoriteableFactory,
        ];
    }
}
