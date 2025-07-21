<?php

namespace Database\Factories;

use App\Models\Award;
use App\Models\Nomination;
use Illuminate\Database\Eloquent\Factories\Factory;

class NominationFactory extends Factory
{
    protected $model = Nomination::class;

    public function definition(): array
    {
        return [
            'award_id' => Award::factory(),
            'year' => $this->faker->year(),
            'category' => $this->faker->word(),
        ];
    }
}
