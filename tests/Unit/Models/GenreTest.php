<?php

namespace Tests\Unit\Models;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_created_with_factory(): void
    {
        $genre = Genre::factory()->create();

        $this->assertDatabaseHas('genres', [
            'id' => $genre->id,
            'name' => $genre->name,
        ]);
    }

    /** @test */
    public function it_can_have_books(): void
    {
        $genre = Genre::factory()->create();
        $books = Book::factory()->count(3)->create();

        $genre->books()->attach($books->pluck('id'));

        $this->assertCount(3, $genre->books);
        $this->assertTrue($genre->books->contains($books->first()));
    }

    /** @test */
    public function it_can_have_a_parent_genre(): void
    {
        $parent = Genre::factory()->create();
        $child = Genre::factory()->create(['parent_id' => $parent->id]);

        $this->assertEquals($parent->id, $child->parent->id);
    }

    /** @test */
    public function it_can_have_children_genres(): void
    {
        $parent = Genre::factory()->create();
        $children = Genre::factory()->count(2)->create(['parent_id' => $parent->id]);

        $this->assertCount(2, $parent->children);
        $this->assertTrue($parent->children->contains($children->first()));
    }
}
