<?php

namespace Database\Factories;

use App\Enums\Gender;
use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password123'),
            'email_verified_at' => $this->faker->dateTimeThisYear(),
            'profile_picture' => 'https://placehold.co/300x300',
            'bio' => $this->faker->paragraph(),
            'is_public' => $this->faker->boolean(),
            'birthday' => $this->faker->dateTimeBetween('-80 years', '-18 years'),
            'location' => $this->faker->city(),
            'last_login' => $this->faker->dateTimeThisYear(),
            'social_media_links' => collect([
                'twitter' => $this->faker->url(),
                'facebook' => $this->faker->url(),
            ]),
            'role' => $this->faker->randomElement(Role::cases()),
            'gender' => $this->faker->randomElement(Gender::cases()),
        ];
    }

    public function admin(): static
    {
        return $this->state([
            'role' => Role::ADMIN,
        ]);
    }
}
