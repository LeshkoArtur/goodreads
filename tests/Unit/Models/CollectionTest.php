<?php

namespace Tests\Unit\Models;

use App\Models\Book;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_valid_collection()
    {
        $collection = Collection::factory()->create();

        $this->assertDatabaseHas('collections', [
            'id' => $collection->id,
            'title' => $collection->title,
        ]);
    }

    /** @test */
    public function user_id_is_required()
    {
        $data = Collection::factory()->make(['user_id' => null])->toArray();

        $validator = Validator::make($data, [
            'user_id' => 'required|uuid|exists:users,id',
        ]);

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function title_is_required()
    {
        $data = Collection::factory()->make(['title' => null])->toArray();

        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
        ]);

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function is_public_must_be_boolean()
    {
        $data = Collection::factory()->raw([
            'is_public' => 'not-boolean',
        ]);

        $validator = Validator::make($data, [
            'is_public' => 'boolean',
        ]);

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $collection = Collection::factory()->create();

        $this->assertInstanceOf(User::class, $collection->user);
    }

    /** @test */
    public function it_belongs_to_many_books()
    {
        $collection = Collection::factory()->create();
        $book = Book::factory()->create();

        $collection->books()->attach($book->id, ['order_index' => 1]);

        $this->assertCount(1, $collection->books);
        $this->assertEquals(1, $collection->books->first()->pivot->order_index);
    }

    /** @test */
    public function cover_image_is_optional_but_should_be_valid_url_if_provided()
    {
        $data = Collection::factory()->make(['cover_image' => 'invalid-url'])->toArray();

        $validator = Validator::make($data, [
            'cover_image' => 'nullable|url',
        ]);

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function description_is_nullable_and_can_be_text()
    {
        $data = Collection::factory()->make(['description' => null])->toArray();

        $validator = Validator::make($data, [
            'description' => 'nullable|string',
        ]);

        $this->assertFalse($validator->fails());
    }
}
