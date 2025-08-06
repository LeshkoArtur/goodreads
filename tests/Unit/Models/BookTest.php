<?php

namespace Tests\Unit\Models;

use App\Enums\AgeRestriction;
use App\Enums\CoverType;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookSeries;
use App\Models\Collection;
use App\Models\Genre;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use ValueError;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_created_with_valid_data()
    {
        $book = Book::factory()->create([
            'title' => 'Test Book',
            'page_count' => 321,
            'average_rating' => 4.75,
            'is_bestseller' => true,
            'age_restriction' => AgeRestriction::TWELVE_PLUS,
        ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Test Book',
            'page_count' => 321,
        ]);

        $this->assertTrue($book->is_bestseller);
        $this->assertEquals(4.75, $book->average_rating);
        $this->assertEquals(AgeRestriction::TWELVE_PLUS, $book->age_restriction);
    }

    /** @test */
    public function it_casts_collections_properly()
    {
        $book = Book::factory()->create([
            'languages' => collect(['en', 'fr']),
            'fun_facts' => collect(['fact1', 'fact2']),
            'adaptations' => collect(['film', 'series']),
        ]);

        $this->assertEquals(['en', 'fr'], $book->languages->all());
        $this->assertEquals(['fact1', 'fact2'], $book->fun_facts->all());
        $this->assertEquals(['film', 'series'], $book->adaptations->all());
    }

    /** @test */
    public function it_belongs_to_a_series()
    {
        $book = Book::factory()->create();
        $this->assertInstanceOf(BookSeries::class, $book->series);
    }

    /** @test */
    public function it_has_authors()
    {
        $book = Book::factory()->create();
        $authors = Author::factory()->count(2)->create();
        $book->authors()->attach($authors->pluck('id'));

        $this->assertCount(2, $book->authors);
    }

    /** @test */
    public function it_has_genres()
    {
        $book = Book::factory()->create();
        $genres = Genre::factory()->count(2)->create();
        $book->genres()->attach($genres->pluck('id'));

        $this->assertCount(2, $book->genres);
    }

    /** @test */
    public function it_has_publishers_with_pivot_fields()
    {
        $book = Book::factory()->create();
        $publisher = Publisher::factory()->create();

        $book->publishers()->attach($publisher->id, [
            'published_date' => now(),
            'isbn' => '1234567890',
            'circulation' => 5000,
            'format' => 'Paperback',
            'cover_type' => CoverType::PAPERBACK,
            'translator' => 'John Doe',
            'edition' => 2,
            'price' => 199.99,
            'binding' => 'Glued',
        ]);

        $this->assertCount(1, $book->publishers);
        $this->assertEquals('1234567890', $book->publishers->first()->pivot->isbn);
    }

    /** @test */
    public function it_can_be_favorited()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->favorites()->create(['user_id' => $user->id]);

        $this->assertCount(1, $book->favorites);
        $this->assertEquals($user->id, $book->favorites->first()->user_id);
    }

    /** @test */
    public function it_can_be_added_to_collections()
    {
        $book = Book::factory()->create();
        $collection = Collection::factory()->create();

        $book->collections()->attach($collection->id, ['order_index' => 1]);

        $this->assertCount(1, $book->collections);
        $this->assertEquals(1, $book->collections->first()->pivot->order_index);
    }

    /** @test */
    public function it_casts_age_restriction_enum()
    {
        $book = Book::factory()->create([
            'age_restriction' => AgeRestriction::EIGHTEEN_PLUS,
        ]);

        $this->assertInstanceOf(AgeRestriction::class, $book->age_restriction);
        $this->assertEquals(AgeRestriction::EIGHTEEN_PLUS, $book->age_restriction);
    }

    /** @test */
    public function it_fails_with_invalid_age_restriction()
    {
        $this->expectException(ValueError::class);

        Book::factory()->create([
            'age_restriction' => 'not-valid-enum',
        ]);
    }
}
