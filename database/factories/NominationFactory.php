<?php

namespace Database\Factories;

use App\Models\Award;
use App\Models\Nomination;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nomination>
 */
class NominationFactory extends Factory
{
    protected $model = Nomination::class;

    public function definition(): array
    {
        return [
            'award_id' => Award::factory(),
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
        ];
    }
}
