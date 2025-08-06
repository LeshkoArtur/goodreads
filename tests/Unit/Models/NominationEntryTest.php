<?php

namespace Tests\Unit\Models;

use App\Models\Nomination;
use App\Models\Book;
use App\Models\Author;
use App\Models\NominationEntry;
use App\Enums\NominationStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class NominationEntryTest extends TestCase
{
    use RefreshDatabase;

    public function test_nomination_entry_factory_creates_valid_entry(): void
    {
        $entry = NominationEntry::factory()->create();

        $this->assertInstanceOf(NominationEntry::class, $entry);
        $this->assertDatabaseHas('nomination_entries', ['id' => $entry->id]);
    }

    public function test_nomination_entry_belongs_to_nomination(): void
    {
        $entry = NominationEntry::factory()->create();

        $this->assertInstanceOf(Nomination::class, $entry->nomination);
    }

    public function test_nomination_entry_belongs_to_book(): void
    {
        $entry = NominationEntry::factory()->create();

        $this->assertInstanceOf(Book::class, $entry->book);
    }

    public function test_nomination_entry_belongs_to_author(): void
    {
        $entry = NominationEntry::factory()->create();

        $this->assertInstanceOf(Author::class, $entry->author);
    }

    public function test_status_is_cast_to_enum(): void
    {
        $entry = NominationEntry::factory()->create([
            'status' => NominationStatus::FINALIST,
        ]);

        $this->assertInstanceOf(NominationStatus::class, $entry->status);
        $this->assertEquals(NominationStatus::FINALIST, $entry->status);
    }

    public function test_fillable_fields_are_assignable(): void
    {
        $data = [
            'nomination_id' => Nomination::factory()->create()->id,
            'book_id' => Book::factory()->create()->id,
            'author_id' => Author::factory()->create()->id,
            'status' => NominationStatus::WINNER,
        ];

        $entry = new NominationEntry();
        $entry->fill($data);

        $this->assertEquals($data['nomination_id'], $entry->nomination_id);
        $this->assertEquals($data['book_id'], $entry->book_id);
        $this->assertEquals($data['author_id'], $entry->author_id);
        $this->assertEquals($data['status'], $entry->status);
    }

    public function test_status_field_validation(): void
    {
        $data = [
            'status' => 'invalid_status',
        ];

        $validator = Validator::make($data, [
            'status' => function ($attribute, $value, $fail) {
                if (!NominationStatus::tryFrom($value)) {
                    $fail("The $attribute must be a valid NominationStatus.");
                }
            },
        ]);

        $this->assertTrue($validator->fails());
    }
}
