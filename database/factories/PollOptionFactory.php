<?php

namespace Database\Factories;

use App\Models\GroupPoll;
use App\Models\PollOption;
use Illuminate\Database\Eloquent\Factories\Factory;

class PollOptionFactory extends Factory
{
    protected $model = PollOption::class;

    public function definition(): array
    {
        return [
            'poll_id' => GroupPoll::factory(),
            'option_text' => $this->faker->words(3, true),
        ];
    }
}
