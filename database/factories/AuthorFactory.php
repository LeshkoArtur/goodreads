<?php

namespace Database\Factories;

use App\Enums\TypeOfWork;
use     App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    protected $model = Author::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'bio' => $this->faker->text(),
            'birth_date' => $this->faker->date(),
            'birth_place' => $this->faker->city(),
            'nationality' => $this->faker->country(),
            'website' => $this->faker->url(),
            'profile_picture' => $this->faker->imageUrl(400, 400),
            'death_date' => $this->faker->date(),
            'social_media_links' => [
                'twitter' => $this->faker->url(),
                'facebook' => $this->faker->url(),
                'instagram' => $this->faker->url(),
            ],
            'media_images' => [
                $this->faker->imageUrl(640, 480),
                $this->faker->imageUrl(640, 480),
            ],
            'media_videos' => [
                'https://youtu.be/' . $this->faker->lexify('??????????'),
            ],
            'fun_facts' => [$this->faker->sentence()],
            'type_of_work' => $this->faker->randomElement(TypeOfWork::cases())->value,
        ];
    }
}
