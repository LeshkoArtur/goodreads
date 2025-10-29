<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    protected $model = Store::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'logo_url' => 'https://placehold.co/300x200',
            'region' => substr($this->faker->city(), 0, 100),
            'website_url' => substr($this->faker->url(), 0, 255),
        ];
    }
}
