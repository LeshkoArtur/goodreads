<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\GroupInvitation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupInvitationFactory extends Factory
{
    protected $model = GroupInvitation::class;

    public function definition(): array
    {
        return [
            'group_id' => Group::factory(),
            'inviter_id' => User::factory(),
            'invitee_id' => User::factory(),
            'status' => $this->faker->randomElement(['pending', 'accepted', 'declined']),
        ];
    }
}
