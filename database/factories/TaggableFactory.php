<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\Taggable;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaggableFactory extends Factory
{
    protected $model = Taggable::class;

    public function definition(): array
    {
        return [
            'tag_id' => Tag::factory(),
            'taggable_type' => $this->faker->randomElement(['App\Models\Book', 'App\Models\Quote']),
        ];
    }
}
