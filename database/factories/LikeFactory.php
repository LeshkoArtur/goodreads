<?php

namespace Database\Factories;

use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    protected $model = Like::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'likeable_id' => $this->faker->uuid(),
            'likeable_type' => $this->faker->randomElement(['App\\Models\\Post', 'App\\Models\\Comment']),
        ];
    }
}
