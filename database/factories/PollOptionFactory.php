<?php

namespace Database\Factories;

use App\Models\GroupPoll;
use App\Models\PollOption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PollOption>
 */
class PollOptionFactory extends Factory
{
    protected $model = PollOption::class;

    public function definition(): array
    {
        return [
            'group_poll_id' => GroupPoll::factory(),
            'text' => $this->faker->sentence(),
            'vote_count' => $this->faker->numberBetween(0, 100),
        ];
    }
}
