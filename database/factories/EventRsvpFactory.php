<?php

namespace Database\Factories;

use App\Enums\EventResponse;
use App\Models\EventRsvp;
use App\Models\GroupEvent;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventRsvp>
 */
class EventRsvpFactory extends Factory
{
    protected $model = EventRsvp::class;

    public function definition(): array
    {
        return [
            'group_event_id' => GroupEvent::factory(),
            'user_id' => User::factory(),
            'response' => $this->faker->randomElement(EventResponse::cases()),
        ];
    }
}
