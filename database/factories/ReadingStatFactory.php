<?php

namespace Database\Factories;

use App\Models\ReadingStat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReadingStat>
 */
class ReadingStatFactory extends Factory
{
    protected $model = ReadingStat::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'year' => $this->faker->year(),
            'books_read' => $this->faker->numberBetween(0, 100),
            'pages_read' => $this->faker->numberBetween(0, 30000),
            'genres_read' => [$this->faker->word(), $this->faker->word()],
        ];
    }
}
