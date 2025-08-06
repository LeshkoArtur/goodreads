<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Group;
use App\Models\GroupModerationLog;
use App\Models\GroupPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GroupModerationLog>
 */
class GroupModerationLogFactory extends Factory
{
    protected $model = GroupModerationLog::class;

    public function definition(): array
    {
        $targetableTypes = [
            GroupPost::class => GroupPost::factory(),
            Comment::class => Comment::factory(),
        ];

        $targetableType = $this->faker->randomElement(array_keys($targetableTypes));
        $targetableFactory = $targetableTypes[$targetableType];

        return [
            'group_id' => Group::factory(),
            'moderator_id' => User::factory(),
            'action' => $this->faker->word(),
            'targetable_type' => $targetableType,
            'targetable_id' => $targetableFactory,
            'description' => $this->faker->sentence(),
        ];
    }
}
