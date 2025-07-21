<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\GroupPoll;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupPollFactory extends Factory
{
    protected $model = GroupPoll::class;

    public function definition(): array
    {
        return [
            'group_id' => Group::factory(),
            'question' => $this->faker->sentence(),
        ];
    }
}
