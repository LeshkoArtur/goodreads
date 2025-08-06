<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\GroupPoll;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GroupPoll>
 */
class GroupPollFactory extends Factory
{
    protected $model = GroupPoll::class;

    public function definition(): array
    {
        return [
            'group_id' => Group::factory(),
            'creator_id' => User::factory(),
            'question' => $this->faker->sentence(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
