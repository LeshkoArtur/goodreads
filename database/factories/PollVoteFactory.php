<?php

namespace Database\Factories;

use App\Models\GroupPoll;
use App\Models\PollOption;
use App\Models\PollVote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PollVote>
 */
class PollVoteFactory extends Factory
{
    protected $model = PollVote::class;

    public function definition(): array
    {
        return [
            'group_poll_id' => GroupPoll::factory(),
            'poll_option_id' => PollOption::factory(),
            'user_id' => User::factory(),
            'created_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
