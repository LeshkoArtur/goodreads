<?php

namespace Database\Factories;

use     App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    protected $model = Author::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'bio' => $this->faker->paragraph(),
            'birth_date' => $this->faker->date(),
            'birth_place' => $this->faker->city(),
            'nationality' => $this->faker->country(),
            'type_of_work' => $this->faker->randomElement(['novelist', 'short_story_writer', 'poet', 'playwright', 'screenwriter', 'essayist', 'biographer', 'memoirist', 'historian', 'journalist', 'science_writer', 'self_help_writer', 'children_writer', 'young_adult_writer', 'graphic_novelist', 'fantasy_writer', 'sci_fi_writer', 'mystery_writer', 'romance_writer', 'horror_writer', 'other']),
            'website' => $this->faker->url(),
            'profile_picture' => $this->faker->imageUrl(),
            'death_date' => null,
            'social_media_links' => [],
            'media_images' => [],
            'media_videos' => [],
            'fun_facts' => [],
        ];
    }
}
