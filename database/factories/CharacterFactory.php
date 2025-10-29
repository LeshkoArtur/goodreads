<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Character;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Character>
 */
class CharacterFactory extends Factory
{
    protected $model = Character::class;

    public function definition(): array
    {
        return [
            'book_id' => Book::factory(),
            'name' => $this->faker->name(),
            'other_names' => collect([$this->faker->name(), $this->faker->name()]),
            'race' => $this->faker->word(),
            'nationality' => $this->faker->country(),
            'residence' => $this->faker->city(),
            'biography' => $this->faker->paragraph(),
            'fun_facts' => collect([$this->faker->sentence(), $this->faker->sentence()]),
            'links' => collect([$this->faker->url(), $this->faker->url()]),
            'media_images' => collect(['https://placehold.co/400x600', 'https://placehold.co/400x600']),
        ];
    }
}
