<?php

namespace Tests\Unit\Models;

use App\Models\Book;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Like;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuoteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_expected_fillable_attributes()
    {
        $quote = new Quote();

        $this->assertEquals([
            'user_id',
            'book_id',
            'text',
            'page_number',
            'contains_spoilers',
            'is_public',
        ], $quote->getFillable());
    }

    /** @test */
    public function it_casts_attributes_correctly()
    {
        $quote = Quote::factory()->create([
            'page_number' => '123',
            'contains_spoilers' => '1',
            'is_public' => '0',
        ]);

        $this->assertIsInt($quote->page_number);
        $this->assertTrue($quote->contains_spoilers);
        $this->assertFalse($quote->is_public);
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $quote = Quote::factory()->create();

        $this->assertInstanceOf(BelongsTo::class, $quote->user());
        $this->assertInstanceOf(User::class, $quote->user);
    }

    /** @test */
    public function it_belongs_to_book()
    {
        $quote = Quote::factory()->create();

        $this->assertInstanceOf(BelongsTo::class, $quote->book());
        $this->assertInstanceOf(Book::class, $quote->book);
    }

    /** @test */
    public function it_has_many_morph_comments()
    {
        $quote = Quote::factory()->create();

        $this->assertInstanceOf(MorphMany::class, $quote->comments());
    }

    /** @test */
    public function it_has_many_morph_likes()
    {
        $quote = Quote::factory()->create();

        $this->assertInstanceOf(MorphMany::class, $quote->likes());
    }

    /** @test */
    public function it_has_many_morph_favorites()
    {
        $quote = Quote::factory()->create();

        $this->assertInstanceOf(MorphMany::class, $quote->favorites());
    }

    /** @test */
    public function it_can_be_created_with_factory()
    {
        $quote = Quote::factory()->create();

        $this->assertDatabaseHas('quotes', [
            'id' => $quote->id,
            'text' => $quote->text,
        ]);
    }
}
