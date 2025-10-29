<?php

namespace Tests\Unit\Models;

use App\Enums\CoverType;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class PublisherTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_creates_valid_publisher()
    {
        $publisher = Publisher::factory()->create();

        $this->assertDatabaseHas('publishers', [
            'id' => $publisher->id,
            'name' => $publisher->name,
        ]);
    }

    public function test_fillable_fields_are_assignable()
    {
        $data = [
            'name' => 'Test Publisher',
            'description' => 'Test description',
            'website' => 'https://example.com',
            'country' => 'Ukraine',
            'founded_year' => 1990,
            'logo' => 'https://example.com/logo.png',
            'contact_email' => 'contact@example.com',
            'phone' => '+380123456789',
        ];

        $publisher = new Publisher;
        $publisher->fill($data);

        foreach ($data as $field => $value) {
            $this->assertEquals($value, $publisher->$field);
        }
    }

    public function test_casts_are_correct()
    {
        $publisher = Publisher::factory()->make([
            'founded_year' => '2000',
        ]);

        $this->assertIsInt($publisher->founded_year);
        $this->assertEquals(2000, $publisher->founded_year);
    }

    public function test_books_relationship_returns_belongs_to_many()
    {
        $publisher = Publisher::factory()->create();
        $book = Book::factory()->create();

        $publisher->books()->attach($book->id, [
            'published_date' => now()->toDateString(),
            'isbn' => '1234567890',
            'circulation' => 5000,
            'format' => 'Hardcover',
            'cover_type' => CoverType::PAPERBACK,
            'translator' => 'John Doe',
            'edition' => 2,
            'price' => 299.99,
            'binding' => 'Sewn',
        ]);

        $this->assertInstanceOf(BelongsToMany::class, $publisher->books());
        $this->assertEquals(1, $publisher->books()->count());

        $attachedBook = $publisher->books()->first();
        $this->assertEquals($book->id, $attachedBook->id);
        $this->assertEquals('1234567890', $attachedBook->pivot->isbn);
    }

    public function test_validation_rules_pass_with_valid_data()
    {
        $data = [
            'name' => 'Valid Publisher',
            'description' => 'Some description',
            'website' => 'https://validsite.com',
            'country' => 'USA',
            'founded_year' => 2000,
            'logo' => 'https://validsite.com/logo.png',
            'contact_email' => 'email@valid.com',
            'phone' => '+1234567890',
        ];

        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'country' => 'nullable|string|max:100',
            'founded_year' => 'nullable|integer|min:1000|max:'.date('Y'),
            'logo' => 'nullable|url',
            'contact_email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
        ];

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->fails());
    }

    public function test_validation_rules_fail_with_invalid_data()
    {
        $data = [
            'name' => '',
            'website' => 'not-a-url',
            'founded_year' => 999,
            'contact_email' => 'not-an-email',
        ];

        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'country' => 'nullable|string|max:100',
            'founded_year' => 'nullable|integer|min:1000|max:'.date('Y'),
            'logo' => 'nullable|url',
            'contact_email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
        $this->assertArrayHasKey('website', $validator->errors()->toArray());
        $this->assertArrayHasKey('founded_year', $validator->errors()->toArray());
        $this->assertArrayHasKey('contact_email', $validator->errors()->toArray());
    }
}
