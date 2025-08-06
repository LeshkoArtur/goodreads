<?php

namespace Tests\Unit\Models;

use App\Models\Shelf;
use App\Models\User;
use App\Models\UserBook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ShelfTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_expected_fillable_fields()
    {
        $shelf = new Shelf();
        $this->assertEquals(['user_id', 'name'], $shelf->getFillable());
    }

    /** @test */
    public function it_casts_attributes_properly()
    {
        $shelf = Shelf::factory()->create([
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->assertInstanceOf(Carbon::class, $shelf->created_at);
        $this->assertInstanceOf(Carbon::class, $shelf->updated_at);
        $this->assertIsString($shelf->name);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $shelf = Shelf::factory()->for($user)->create();

        $this->assertInstanceOf(User::class, $shelf->user);
        $this->assertEquals($user->id, $shelf->user->id);
    }

    /** @test */
    public function it_has_many_user_books()
    {
        $shelf = Shelf::factory()->create();
        $books = UserBook::factory()->count(3)->for($shelf)->create();

        $this->assertCount(3, $shelf->userBooks);
        $this->assertTrue($shelf->userBooks->contains($books->first()));
    }

    /** @test */
    public function it_can_be_created_with_valid_data()
    {
        $user = User::factory()->create();

        $shelf = Shelf::create([
            'user_id' => $user->id,
            'name' => 'Fiction',
        ]);

        $this->assertDatabaseHas('shelves', [
            'id' => $shelf->id,
            'user_id' => $user->id,
            'name' => 'Fiction',
        ]);
    }

    /** @test */
    public function it_can_be_updated()
    {
        $shelf = Shelf::factory()->create([
            'name' => 'Old Name',
        ]);

        $shelf->update([
            'name' => 'New Name',
        ]);

        $this->assertEquals('New Name', $shelf->fresh()->name);
    }

    /** @test */
    public function deleting_user_deletes_their_shelves_if_cascade_is_set()
    {
        $user = User::factory()->create();
        $shelf = Shelf::factory()->for($user)->create();

        $user->delete();

        $this->assertDatabaseMissing('shelves', ['id' => $shelf->id]);
    }

    /** @test */
    public function shelf_without_user_has_null_relation()
    {
        $shelf = Shelf::factory()->make(['user_id' => null]);

        $this->assertNull($shelf->user);
    }

    /** @test */
    public function shelf_with_no_user_books_returns_empty_collection()
    {
        $shelf = Shelf::factory()->create();

        $this->assertCount(0, $shelf->userBooks);
    }
}
