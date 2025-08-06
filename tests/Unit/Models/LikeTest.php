<?php

namespace Tests\Unit\Models;

use App\Models\GroupPost;
use App\Models\Like;
use App\Models\Post;
use App\Models\Quote;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_like_with_valid_data()
    {
        $like = Like::factory()->create();

        $this->assertDatabaseHas('likes', [
            'id' => $like->id,
            'user_id' => $like->user_id,
            'likeable_type' => $like->likeable_type,
            'likeable_id' => $like->likeable_id,
        ]);

        $this->assertIsString($like->id);
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $like = Like::factory()->create();

        $this->assertInstanceOf(User::class, $like->user);
    }

    /** @test */
    public function it_morphs_to_post()
    {
        $post = Post::factory()->create();
        $like = Like::factory()->create([
            'likeable_type' => Post::class,
            'likeable_id' => $post->id,
        ]);

        $this->assertInstanceOf(Post::class, $like->likeable);
        $this->assertEquals($post->id, $like->likeable->id);
    }

    /** @test */
    public function it_morphs_to_group_post()
    {
        $groupPost = GroupPost::factory()->create();
        $like = Like::factory()->create([
            'likeable_type' => GroupPost::class,
            'likeable_id' => $groupPost->id,
        ]);

        $this->assertInstanceOf(GroupPost::class, $like->likeable);
        $this->assertEquals($groupPost->id, $like->likeable->id);
    }

    /** @test */
    public function it_morphs_to_quote()
    {
        $quote = Quote::factory()->create();
        $like = Like::factory()->create([
            'likeable_type' => Quote::class,
            'likeable_id' => $quote->id,
        ]);

        $this->assertInstanceOf(Quote::class, $like->likeable);
        $this->assertEquals($quote->id, $like->likeable->id);
    }

    /** @test */
    public function it_morphs_to_rating()
    {
        $rating = Rating::factory()->create();
        $like = Like::factory()->create([
            'likeable_type' => Rating::class,
            'likeable_id' => $rating->id,
        ]);

        $this->assertInstanceOf(Rating::class, $like->likeable);
        $this->assertEquals($rating->id, $like->likeable->id);
    }

    /** @test */
    public function user_can_have_multiple_likes()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $quote = Quote::factory()->create();

        $like1 = Like::factory()->create([
            'user_id' => $user->id,
            'likeable_type' => Post::class,
            'likeable_id' => $post->id,
        ]);

        $like2 = Like::factory()->create([
            'user_id' => $user->id,
            'likeable_type' => Quote::class,
            'likeable_id' => $quote->id,
        ]);

        $this->assertCount(2, $user->likes);
        $this->assertTrue($user->likes->contains($like1));
        $this->assertTrue($user->likes->contains($like2));
    }
}
