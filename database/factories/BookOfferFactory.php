<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\Enums\OfferStatus;
use App\Models\Book;
use App\Models\BookOffer;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookOffer>
 */
class BookOfferFactory extends Factory
{
    protected $model = BookOffer::class;

    public function definition(): array
    {
        return [
            'book_id' => Book::factory(),
            'store_id' => Store::factory(),
            'price' => $this->faker->randomFloat(2, 5, 50),
            'currency' => $this->faker->randomElement(Currency::cases()),
            'referral_url' => $this->faker->url(),
            'availability' => $this->faker->boolean(),
            'status' => $this->faker->randomElement(OfferStatus::cases()),
            'last_updated_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
