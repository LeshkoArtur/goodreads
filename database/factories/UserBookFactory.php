<?php

namespace Database\Factories;

use App\Enums\ReadingFormat;
use App\Models\Book;
use App\Models\Shelf;
use App\Models\User;
use App\Models\UserBook;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserBook>
 */
class UserBookFactory extends Factory
{
    protected $model = UserBook::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'shelf_id' => Shelf::factory(),
            'start_date' => $this->faker->dateTimeThisYear(),
            'read_date' => $this->faker->optional()->dateTimeThisYear(),
            'progress_pages' => $this->faker->numberBetween(0, 500),
            'is_private' => $this->faker->boolean(),
            'rating' => $this->faker->numberBetween(1, 5),
            'notes' => $this->faker->paragraph(),
            'reading_format' => $this->faker->randomElement(ReadingFormat::cases()),
        ];
    }
}
