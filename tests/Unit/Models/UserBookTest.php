<?php

namespace Tests\Unit\Models;

use App\Enums\ReadingFormat;
use App\Models\Book;
use App\Models\Shelf;
use App\Models\User;
use App\Models\UserBook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserBookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_expected_fillable_fields()
    {
        $userBook = new UserBook();
        $this->assertEquals([
            'user_id',
            'book_id',
            'shelf_id',
            'start_date',
            'read_date',
            'progress_pages',
            'is_private',
            'rating',
            'notes',
            'reading_format',
        ], $userBook->getFillable());
    }

    /** @test */
    public function it_casts_attributes_correctly()
    {
        $userBook = UserBook::factory()->make();

        $this->assertInstanceOf(\DateTimeInterface::class, $userBook->start_date);
        if ($userBook->read_date !== null) {
            $this->assertInstanceOf(\DateTimeInterface::class, $userBook->read_date);
        }
        $this->assertIsBool($userBook->is_private);
        $this->assertIsInt($userBook->rating);
        $this->assertContains($userBook->reading_format, ReadingFormat::cases());
    }

    /** @test */
    public function it_can_create_a_user_book()
    {
        $userBook = UserBook::factory()->create();

        $this->assertDatabaseHas('user_books', [
            'id' => $userBook->id,
        ]);
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $userBook = UserBook::factory()->create();

        $this->assertInstanceOf(User::class, $userBook->user);
        $this->assertEquals($userBook->user_id, $userBook->user->id);
    }

    /** @test */
    public function it_belongs_to_book()
    {
        $userBook = UserBook::factory()->create();

        $this->assertInstanceOf(Book::class, $userBook->book);
        $this->assertEquals($userBook->book_id, $userBook->book->id);
    }

    /** @test */
    public function it_belongs_to_shelf()
    {
        $userBook = UserBook::factory()->create();

        $this->assertInstanceOf(Shelf::class, $userBook->shelf);
        $this->assertEquals($userBook->shelf_id, $userBook->shelf->id);
    }

    /** @test */
    public function it_allows_null_read_date()
    {
        $userBook = UserBook::factory()->create(['read_date' => null]);

        $this->assertNull($userBook->read_date);
    }
}
