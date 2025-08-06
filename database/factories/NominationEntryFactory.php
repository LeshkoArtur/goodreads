<?php

namespace Database\Factories;

use App\Enums\NominationStatus;
use App\Models\Author;
use App\Models\Book;
use App\Models\Nomination;
use App\Models\NominationEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NominationEntry>
 */
class NominationEntryFactory extends Factory
{
    protected $model = NominationEntry::class;

    public function definition(): array
    {
        return [
            'nomination_id' => Nomination::factory(),
            'book_id' => Book::factory(),
            'author_id' => Author::factory(),
            'status' => $this->faker->randomElement(NominationStatus::cases()),
        ];
    }
}
