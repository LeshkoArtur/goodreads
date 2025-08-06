<?php

namespace Database\Factories;

use App\Enums\EventStatus;
use App\Models\Group;
use App\Models\GroupEvent;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GroupEvent>
 */
class GroupEventFactory extends Factory
{
    protected $model = GroupEvent::class;

    public function definition(): array
    {
        return [
            'group_id' => Group::factory(),
            'creator_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'event_date' => $this->faker->dateTimeThisYear(),
            'location' => $this->faker->address(),
            'status' => $this->faker->randomElement(EventStatus::cases()),
        ];
    }
}
