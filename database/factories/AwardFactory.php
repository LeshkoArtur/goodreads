<?php

namespace Database\Factories;

use App\Models\Award;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Award>
 */
class AwardFactory extends Factory
{
    protected $model = Award::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true) . ' Award',
            'year' => $this->faker->year(),
            'description' => $this->faker->paragraph(),
            'organizer' => $this->faker->company(),
            'country' => $this->faker->country(),
            'ceremony_date' => $this->faker->dateTimeThisYear(),
        ];
    }
}
