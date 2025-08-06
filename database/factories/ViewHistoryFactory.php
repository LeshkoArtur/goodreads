<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\GroupPost;
use App\Models\Post;
use App\Models\User;
use App\Models\ViewHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ViewHistory>
 */
class ViewHistoryFactory extends Factory
{
    protected $model = ViewHistory::class;

    public function definition(): array
    {
        $viewableTypes = [
            Book::class => Book::factory(),
            Post::class => Post::factory(),
            GroupPost::class => GroupPost::factory(),
        ];

        $viewableType = $this->faker->randomElement(array_keys($viewableTypes));
        $viewableFactory = $viewableTypes[$viewableType];

        return [
            'user_id' => User::factory(),
            'viewable_type' => $viewableType,
            'viewable_id' => $viewableFactory,
        ];
    }
}
