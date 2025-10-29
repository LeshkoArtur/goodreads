<?php

namespace Database\Factories;

use App\Enums\AgeRestriction;
use App\Models\Book;
use App\Models\BookSeries;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'plot' => $this->faker->paragraphs(3, true),
            'history' => $this->faker->paragraph(),
            'series_id' => BookSeries::factory(),
            'number_in_series' => $this->faker->numberBetween(1, 10),
            'page_count' => $this->faker->numberBetween(100, 800),
            'languages' => collect([$this->faker->languageCode(), $this->faker->languageCode()]),
            'cover_image' => 'https://placehold.co/300x450',
            'fun_facts' => collect([$this->faker->sentence(), $this->faker->sentence()]),
            'adaptations' => collect([$this->faker->sentence(), $this->faker->sentence()]),
            'is_bestseller' => $this->faker->boolean(),
            'average_rating' => $this->faker->randomFloat(2, 1, 5),
            'age_restriction' => $this->faker->randomElement(AgeRestriction::cases()),
        ];
    }
}
