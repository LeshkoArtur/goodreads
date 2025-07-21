<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Nomination;
use App\Models\NominationEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

class NominationEntryFactory extends Factory
{
    protected $model = NominationEntry::class;

    public function definition(): array
    {
        return [
            'nomination_id' => Nomination::factory(),
            'book_id' => Book::factory(),
            'is_winner' => $this->faker->boolean(),
        ];
    }
}
