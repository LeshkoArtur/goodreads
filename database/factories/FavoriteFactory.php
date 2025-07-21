<?php

namespace Database\Factories;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'user_id' => User::factory(),
            'favoritable_id' => $this->faker->uuid(),
            'favoritable_type' => $this->faker->randomElement(['App\\Models\\Book', 'App\\Models\\Author', 'App\\Models\\Quote',]),
        ];
    }
}
