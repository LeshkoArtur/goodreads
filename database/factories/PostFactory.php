<?php

namespace Database\Factories;

use App\Enums\PostStatus;
use App\Enums\PostType;
use App\Models\Author;
use App\Models\Book;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(3);

        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'author_id' => Author::factory(),
            'title' => $title,
            'content' => $this->faker->paragraph(),
            'cover_image' => 'https://placehold.co/600x400',
            'published_at' => $this->faker->dateTimeThisYear(),
            'type' => $this->faker->randomElement(PostType::cases()),
            'status' => $this->faker->randomElement(PostStatus::cases()),
        ];
    }
}
