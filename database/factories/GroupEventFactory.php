<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\GroupEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupEventFactory extends Factory
{
    protected $model = GroupEvent::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'group_id' => Group::factory(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'event_date' => $this->faker->date(),
        ];
    }
}
