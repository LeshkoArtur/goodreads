<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\GroupModerationLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupModerationLogFactory extends Factory
{
    protected $model = GroupModerationLog::class;

    public function definition(): array
    {
        return [
            'group_id' => Group::factory(),
            'moderator_id' => User::factory(),
            'action' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ];
    }
}
