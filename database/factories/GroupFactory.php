<?php

namespace Database\Factories;

use App\Enums\JoinPolicy;
use App\Enums\PostPolicy;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'creator_id' => User::factory(),
            'is_public' => $this->faker->boolean(),
            'cover_image' => 'https://placehold.co/800x400',
            'rules' => $this->faker->paragraph(),
            'member_count' => $this->faker->numberBetween(1, 1000),
            'is_active' => $this->faker->boolean(),
            'join_policy' => $this->faker->randomElement(JoinPolicy::cases()),
            'post_policy' => $this->faker->randomElement(PostPolicy::cases()),
        ];
    }
}
