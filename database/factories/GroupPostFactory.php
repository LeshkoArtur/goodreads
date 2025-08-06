<?php

namespace Database\Factories;

use App\Enums\PostCategory;
use App\Enums\PostStatus;
use App\Models\Group;
use App\Models\GroupPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GroupPost>
 */
class GroupPostFactory extends Factory
{
    protected $model = GroupPost::class;

    public function definition(): array
    {
        return [
            'group_id' => Group::factory(),
            'user_id' => User::factory(),
            'content' => $this->faker->paragraph(),
            'is_pinned' => $this->faker->boolean(),
            'category' => $this->faker->randomElement(PostCategory::cases()),
            'post_status' => $this->faker->randomElement(PostStatus::cases()),
        ];
    }
}
