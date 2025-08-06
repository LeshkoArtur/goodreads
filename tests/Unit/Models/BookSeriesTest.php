<?php

namespace Tests\Unit;

use App\Models\BookSeries;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class BookSeriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_valid_book_series()
    {
        $series = BookSeries::factory()->create();

        $this->assertDatabaseHas('book_series', [
            'id' => $series->id,
            'title' => $series->title,
        ]);
    }

    public function test_title_is_required()
    {
        $data = BookSeries::factory()->make(['title' => null])->toArray();

        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
        ]);

        $this->assertTrue($validator->fails());
    }

    public function test_description_is_optional_but_string()
    {
        $data = BookSeries::factory()->make(['description' => 12345])->toArray();

        $validator = Validator::make($data, [
            'description' => 'nullable|string',
        ]);

        $this->assertTrue($validator->fails());
    }

    public function test_total_books_must_be_integer()
    {
        $data = BookSeries::factory()->make(['total_books' => 'ten'])->toArray();

        $validator = Validator::make($data, [
            'total_books' => 'required|integer|min:1',
        ]);

        $this->assertTrue($validator->fails());
    }

    public function test_total_books_cannot_be_zero_or_negative()
    {
        $data = BookSeries::factory()->make(['total_books' => 0])->toArray();

        $validator = Validator::make($data, [
            'total_books' => 'required|integer|min:1',
        ]);

        $this->assertTrue($validator->fails());
    }

    public function test_is_completed_must_be_boolean()
    {
        $data = BookSeries::factory()->make(['is_completed' => 'yes'])->toArray();

        $validator = Validator::make($data, [
            'is_completed' => 'required|boolean',
        ]);

        $this->assertTrue($validator->fails());
    }

    public function test_books_relationship_returns_collection()
    {
        $series = BookSeries::factory()->create();
        $book = Book::factory()->create(['series_id' => $series->id]);

        $this->assertTrue($series->books->contains($book));
    }
}
