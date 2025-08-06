<?php

namespace Tests\Unit\Models;

use App\Models\Book;
use App\Models\Favorite;
use App\Models\GroupPost;
use App\Models\Post;
use App\Models\Quote;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_user(): void
    {
        $favorite = Favorite::factory()->create();

        $this->assertInstanceOf(User::class, $favorite->user);
        $this->assertEquals($favorite->user_id, $favorite->user->id);
    }

    /** @test */
    public function it_morphs_to_a_book(): void
    {
        $book = Book::factory()->create();
        $favorite = Favorite::factory()->create([
            'favoriteable_type' => Book::class,
            'favoriteable_id' => $book->id,
        ]);

        $this->assertInstanceOf(Book::class, $favorite->favoriteable);
        $this->assertTrue($favorite->favoriteable->is($book));
    }

    /** @test */
    public function it_morphs_to_a_post(): void
    {
        $post = Post::factory()->create();
        $favorite = Favorite::factory()->create([
            'favoriteable_type' => Post::class,
            'favoriteable_id' => $post->id,
        ]);

        $this->assertInstanceOf(Post::class, $favorite->favoriteable);
        $this->assertTrue($favorite->favoriteable->is($post));
    }

    /** @test */
    public function it_morphs_to_a_group_post(): void
    {
        $groupPost = GroupPost::factory()->create();
        $favorite = Favorite::factory()->create([
            'favoriteable_type' => GroupPost::class,
            'favoriteable_id' => $groupPost->id,
        ]);

        $this->assertInstanceOf(GroupPost::class, $favorite->favoriteable);
        $this->assertTrue($favorite->favoriteable->is($groupPost));
    }

    /** @test */
    public function it_morphs_to_a_quote(): void
    {
        $quote = Quote::factory()->create();
        $favorite = Favorite::factory()->create([
            'favoriteable_type' => Quote::class,
            'favoriteable_id' => $quote->id,
        ]);

        $this->assertInstanceOf(Quote::class, $favorite->favoriteable);
        $this->assertTrue($favorite->favoriteable->is($quote));
    }

    /** @test */
    public function it_morphs_to_a_rating(): void
    {
        $rating = Rating::factory()->create();
        $favorite = Favorite::factory()->create([
            'favoriteable_type' => Rating::class,
            'favoriteable_id' => $rating->id,
        ]);

        $this->assertInstanceOf(Rating::class, $favorite->favoriteable);
        $this->assertTrue($favorite->favoriteable->is($rating));
    }

    /** @test */
    public function it_validates_is_public_as_boolean(): void
    {
        $valid = Favorite::factory()->make(['is_public' => true])->toArray();
        $validator = Validator::make($valid, [
            'is_public' => 'boolean',
        ]);
        $this->assertFalse($validator->fails());

        $invalid = Favorite::factory()->make(['is_public' => 'not-boolean'])->toArray();
        $validator = Validator::make($invalid, [
            'is_public' => 'boolean',
        ]);
        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function it_can_store_all_favoriteable_types(): void
    {
        $user = User::factory()->create();

        $favoriteables = [
            Book::factory()->create(),
            Post::factory()->create(),
            GroupPost::factory()->create(),
            Quote::factory()->create(),
            Rating::factory()->create(),
        ];

        foreach ($favoriteables as $item) {
            $favorite = Favorite::factory()->create([
                'user_id' => $user->id,
                'favoriteable_type' => get_class($item),
                'favoriteable_id' => $item->id,
            ]);

            $this->assertDatabaseHas('favorites', [
                'id' => $favorite->id,
                'user_id' => $user->id,
                'favoriteable_type' => get_class($item),
                'favoriteable_id' => $item->id,
            ]);

            $this->assertTrue($favorite->favoriteable->is($item));
        }
    }
}
