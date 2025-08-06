<?php

namespace Tests\Unit\Models;

use App\Enums\PostStatus;
use App\Enums\PostType;
use App\Models\Author;
use App\Models\Book;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Like;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_post()
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(Post::class, $post);
        $this->assertNotNull($post->title);
        $this->assertNotNull($post->slug);
        $this->assertNotNull($post->content);
        $this->assertNotNull($post->published_at);
    }

    public function test_it_casts_enums_correctly()
    {
        $post = Post::factory()->create([
            'type' => PostType::ARTICLE,
            'status' => PostStatus::DRAFT,
        ]);

        $this->assertInstanceOf(PostType::class, $post->type);
        $this->assertEquals(PostType::ARTICLE, $post->type);

        $this->assertInstanceOf(PostStatus::class, $post->status);
        $this->assertEquals(PostStatus::DRAFT, $post->status);
    }

    public function test_it_belongs_to_user()
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(User::class, $post->user);
    }

    public function test_it_belongs_to_book()
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(Book::class, $post->book);
    }

    public function test_it_belongs_to_author()
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(Author::class, $post->author);
    }

    public function test_it_has_many_comments()
    {
        $post = Post::factory()->create();

        $post->comments()->createMany([
            Comment::factory()->make()->toArray(),
            Comment::factory()->make()->toArray(),
        ]);

        $this->assertCount(2, $post->comments);
        $this->assertInstanceOf(Comment::class, $post->comments->first());
    }

    public function test_it_has_many_likes()
    {
        $post = Post::factory()->create();

        $post->likes()->createMany([
            Like::factory()->make()->toArray(),
            Like::factory()->make()->toArray(),
        ]);

        $this->assertCount(2, $post->likes);
        $this->assertInstanceOf(Like::class, $post->likes->first());
    }

    public function test_it_has_many_favorites()
    {
        $post = Post::factory()->create();

        $post->favorites()->createMany([
            Favorite::factory()->make()->toArray(),
            Favorite::factory()->make()->toArray(),
        ]);

        $this->assertCount(2, $post->favorites);
        $this->assertInstanceOf(Favorite::class, $post->favorites->first());
    }

    public function test_it_can_have_tags()
    {
        $post = Post::factory()->create();

        $tags = Tag::factory()->count(2)->create();
        $post->tags()->attach($tags);

        $this->assertCount(2, $post->tags);
        $this->assertInstanceOf(Tag::class, $post->tags->first());
    }

    public function test_slug_is_set_correctly()
    {
        $post = Post::factory()->create([
            'title' => 'Test Slug Title',
        ]);

        $this->assertEquals('test-slug-title', $post->slug);
    }
}
