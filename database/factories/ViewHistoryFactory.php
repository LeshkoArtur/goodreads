<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\ViewHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ViewHistoryFactory extends Factory
{
    protected $model = ViewHistory::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'viewable_id' => $this->faker->uuid(),
            'viewable_type' => $this->faker->randomElement(['App\\Models\\Book', 'App\\Models\\Quote']),
        ];
    }
}
