<?php

namespace Tests\Unit\Models;

use App\Models\{Rating, User, Book, Comment, Like, Favorite};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, MorphMany};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RatingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_expected_fillable_fields(): void
    {
        $rating = new Rating();

        $this->assertEquals([
            'user_id',
            'book_id',
            'rating',
            'review',
        ], $rating->getFillable());
    }

    /** @test */
    public function it_casts_rating_to_integer(): void
    {
        $rating = Rating::factory()->create([
            'rating' => '4',
        ]);

        $this->assertIsInt($rating->rating);
        $this->assertSame(4, $rating->rating);
    }

    /** @test */
    public function it_uses_uuids(): void
    {
        $rating = Rating::factory()->create();

        $this->assertIsString($rating->getKey());
        $this->assertTrue(strlen($rating->getKey()) === 36);
    }

    /** @test */
    public function it_belongs_to_a_user(): void
    {
        $rating = Rating::factory()->create();

        $this->assertInstanceOf(BelongsTo::class, $rating->user());
        $this->assertInstanceOf(User::class, $rating->user()->first());
    }

    /** @test */
    public function it_belongs_to_a_book(): void
    {
        $rating = Rating::factory()->create();

        $this->assertInstanceOf(BelongsTo::class, $rating->book());
        $this->assertInstanceOf(Book::class, $rating->book()->first());
    }

    /** @test */
    public function it_has_many_comments(): void
    {
        $rating = Rating::factory()->create();
        $comment = Comment::factory()->create([
            'commentable_id' => $rating->id,
            'commentable_type' => Rating::class,
        ]);

        $this->assertInstanceOf(MorphMany::class, $rating->comments());
        $this->assertTrue($rating->comments->contains($comment));
    }

    /** @test */
    public function it_has_many_likes(): void
    {
        $rating = Rating::factory()->create();
        $like = Like::factory()->create([
            'likeable_id' => $rating->id,
            'likeable_type' => Rating::class,
        ]);

        $this->assertInstanceOf(MorphMany::class, $rating->likes());
        $this->assertTrue($rating->likes->contains($like));
    }

    /** @test */
    public function it_has_many_favorites(): void
    {
        $rating = Rating::factory()->create();
        $favorite = Favorite::factory()->create([
            'favoriteable_id' => $rating->id,
            'favoriteable_type' => Rating::class,
        ]);

        $this->assertInstanceOf(MorphMany::class, $rating->favorites());
        $this->assertTrue($rating->favorites->contains($favorite));
    }
}
