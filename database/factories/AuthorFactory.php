<?php

namespace Database\Factories;

use App\Enums\TypeOfWork;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    protected $model = Author::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'bio' => $this->faker->paragraph(),
            'birth_date' => $this->faker->dateTimeBetween('-80 years', '-20 years'),
            'birth_place' => $this->faker->city(),
            'nationality' => $this->faker->country(),
            'website' => $this->faker->url(),
            'profile_picture' => 'https://placehold.co/300x300',
            'death_date' => $this->faker->boolean(20) ? $this->faker->dateTimeBetween('-20 years', 'now') : null,
            'social_media_links' => collect([
                'twitter' => $this->faker->url(),
                'facebook' => $this->faker->url(),
            ]),
            'media_images' => collect(['https://placehold.co/400x600', 'https://placehold.co/400x600']),
            'media_videos' => collect([$this->faker->url(), $this->faker->url()]),
            'fun_facts' => collect([$this->faker->sentence(), $this->faker->sentence()]),
            'type_of_work' => $this->faker->randomElement(TypeOfWork::cases()),
        ];
    }
}
