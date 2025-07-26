<?php

namespace Database\Factories;

use App\Enums\AgeRestriction;
use App\Models\Book;
use App\Models\BookSeries;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'plot' => $this->faker->paragraph(3),
            'history' => $this->faker->paragraph(2),
            'series_id' => BookSeries::factory(),
            'number_in_series' => $this->faker->numberBetween(1, 10),
            'page_count' => $this->faker->numberBetween(100, 1000),
            'languages' => json_encode([$this->faker->languageCode, $this->faker->languageCode]),
            'cover_image' => $this->faker->imageUrl(400, 600, 'books'),
            'fun_facts' => json_encode([$this->faker->sentence(), $this->faker->sentence()]),
            'adaptations' => json_encode([$this->faker->sentence(), $this->faker->sentence()]),
            'is_bestseller' => $this->faker->boolean(),
            'average_rating' => $this->faker->randomFloat(2, 0, 5),
            'age_restriction' => AgeRestriction::SIX_PLUS->value,
        ];
    }
}
