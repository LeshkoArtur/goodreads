<?php

namespace Tests\Unit\Models;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_expected_fillable_fields()
    {
        $tag = new Tag;
        $this->assertEquals(['name'], $tag->getFillable());
    }

    /** @test */
    public function it_can_create_a_tag()
    {
        $tag = Tag::factory()->create([
            'name' => 'Laravel',
        ]);

        $this->assertDatabaseHas('tags', [
            'id' => $tag->id,
            'name' => 'Laravel',
        ]);
    }

    /** @test */
    public function it_can_update_a_tag()
    {
        $tag = Tag::factory()->create(['name' => 'PHP']);

        $tag->update(['name' => 'Updated PHP']);

        $this->assertEquals('Updated PHP', $tag->fresh()->name);
    }

    /** @test */
    public function it_has_many_posts_relationship()
    {
        $tag = Tag::factory()->create();

        $posts = Post::factory()->count(2)->create();

        $tag->posts()->attach($posts->pluck('id'));

        $this->assertCount(2, $tag->posts);
        $this->assertTrue($tag->posts->contains($posts->first()));
    }

    /** @test */
    public function posts_relation_returns_empty_collection_if_no_posts()
    {
        $tag = Tag::factory()->create();

        $this->assertCount(0, $tag->posts);
    }
}
