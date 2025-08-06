<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_note_with_valid_data()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $note = Note::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'text' => 'This is a test note.',
            'page_number' => 123,
            'contains_spoilers' => true,
            'is_private' => false,
        ]);

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'user_id' => $user->id,
            'book_id' => $book->id,
            'text' => 'This is a test note.',
            'page_number' => 123,
            'contains_spoilers' => true,
            'is_private' => false,
        ]);
    }

    /** @test */
    public function it_fails_to_create_note_with_missing_required_fields()
    {
        $this->expectException(QueryException::class);

        Note::create([]);
    }

    /** @test */
    public function it_casts_booleans_correctly()
    {
        $note = Note::factory()->create([
            'contains_spoilers' => 1,
            'is_private' => 0,
        ]);

        $this->assertTrue($note->contains_spoilers);
        $this->assertFalse($note->is_private);
    }

    /** @test */
    public function it_validates_page_number_as_integer()
    {
        $note = Note::factory()->make([
            'page_number' => 'not-a-number',
        ])->toArray();

        $validator = validator($note, [
            'page_number' => 'required|integer',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('page_number', $validator->errors()->toArray());
    }

    /** @test */
    public function it_can_filter_public_notes()
    {
        $publicNote = Note::factory()->create(['is_private' => false]);
        $privateNote = Note::factory()->create(['is_private' => true]);

        $publicNotes = Note::where('is_private', false)->get();

        $this->assertTrue($publicNotes->contains($publicNote));
        $this->assertFalse($publicNotes->contains($privateNote));
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $note = Note::factory()->create();

        $this->assertInstanceOf(User::class, $note->user);
    }

    /** @test */
    public function it_belongs_to_a_book()
    {
        $note = Note::factory()->create();

        $this->assertInstanceOf(Book::class, $note->book);
    }

    /** @test */
    public function factory_generates_valid_note()
    {
        $note = Note::factory()->create();

        $this->assertDatabaseHas('notes', ['id' => $note->id]);
        $this->assertIsInt($note->page_number);
        $this->assertIsBool($note->contains_spoilers);
        $this->assertIsBool($note->is_private);
    }
}
