<?php

namespace Tests\Unit\Models;

use App\Models\Book;
use App\Models\Character;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CharacterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_valid_character()
    {
        $character = Character::factory()->create();

        $this->assertDatabaseHas('characters', [
            'id' => $character->id,
            'name' => $character->name,
        ]);

        $this->assertInstanceOf(Character::class, $character);
        $this->assertInstanceOf(Book::class, $character->book);
    }

    /** @test */
    public function it_casts_collections_correctly()
    {
        $character = Character::factory()->create();

        $this->assertInstanceOf(Collection::class, $character->other_names);
        $this->assertInstanceOf(Collection::class, $character->fun_facts);
        $this->assertInstanceOf(Collection::class, $character->links);
        $this->assertInstanceOf(Collection::class, $character->media_images);
    }

    /** @test */
    public function it_fails_without_required_fields()
    {
        $this->expectException(QueryException::class);

        Character::create([]);
    }

    /** @test */
    public function it_requires_a_name()
    {
        $book = Book::factory()->create();

        $this->expectException(QueryException::class);

        Character::create([
            'book_id' => $book->id,
        ]);
    }

    /** @test */
    public function it_requires_a_valid_book_id()
    {
        $this->expectException(QueryException::class);

        Character::create([
            'book_id' => 'invalid-uuid',
            'name' => 'Invalid Character',
        ]);
    }

    /** @test */
    public function it_accepts_empty_collections()
    {
        $character = Character::create([
            'book_id' => Book::factory()->create()->id,
            'name' => 'Empty Character',
            'other_names' => collect(),
            'race' => null,
            'nationality' => null,
            'residence' => null,
            'biography' => null,
            'fun_facts' => collect(),
            'links' => collect(),
            'media_images' => collect(),
        ]);

        $this->assertInstanceOf(Collection::class, $character->other_names);
        $this->assertTrue($character->other_names->isEmpty());
    }

    /** @test */
    public function it_saves_and_retrieves_complex_collections()
    {
        $otherNames = collect(['Alias One', 'Alias Two']);
        $funFacts = collect(['Fact 1', 'Fact 2']);
        $links = collect(['https://example.com', 'https://another.com']);
        $images = collect(['https://img.com/a.jpg', 'https://img.com/b.jpg']);

        $character = Character::create([
            'book_id' => Book::factory()->create()->id,
            'name' => 'Detailed Character',
            'other_names' => $otherNames,
            'race' => 'Elf',
            'nationality' => 'Narnia',
            'residence' => 'Narnia Castle',
            'biography' => 'Some biography.',
            'fun_facts' => $funFacts,
            'links' => $links,
            'media_images' => $images,
        ]);

        $this->assertEquals($otherNames, $character->other_names);
        $this->assertEquals($funFacts, $character->fun_facts);
        $this->assertEquals($links, $character->links);
        $this->assertEquals($images, $character->media_images);
    }

    /** @test */
    public function character_belongs_to_book()
    {
        $character = Character::factory()->create();

        $this->assertInstanceOf(Book::class, $character->book);
    }
}
