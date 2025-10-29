<?php

namespace Tests\Unit\Models;

use App\Models\ReadingStat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ReadingStatTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_expected_fillable_attributes()
    {
        $model = new ReadingStat;

        $this->assertEquals([
            'user_id',
            'year',
            'books_read',
            'pages_read',
            'genres_read',
        ], $model->getFillable());
    }

    /** @test */
    public function it_casts_attributes_properly()
    {
        $model = new ReadingStat([
            'year' => '2023',
            'books_read' => '10',
            'pages_read' => '2500',
            'genres_read' => ['fantasy', 'sci-fi'],
        ]);

        $this->assertIsInt($model->year);
        $this->assertIsInt($model->books_read);
        $this->assertIsInt($model->pages_read);
        $this->assertIsArray($model->genres_read);
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $readingStat = ReadingStat::factory()->create();

        $this->assertInstanceOf(User::class, $readingStat->user);
    }

    /** @test */
    public function it_can_store_and_retrieve_genres_array()
    {
        $genres = ['drama', 'comedy', 'horror'];

        $stat = ReadingStat::factory()->create([
            'genres_read' => $genres,
        ]);

        $this->assertEquals($genres, $stat->fresh()->genres_read);
    }

    /** @test */
    public function updated_at_is_cast_to_datetime()
    {
        $stat = ReadingStat::factory()->create();
        $this->assertInstanceOf(Carbon::class, $stat->updated_at);
    }

    /** @test */
    public function it_can_be_created_with_factory()
    {
        $stat = ReadingStat::factory()->create();

        $this->assertDatabaseHas('reading_stats', [
            'id' => $stat->id,
        ]);
    }

    /** @test */
    public function it_accepts_custom_values()
    {
        $user = User::factory()->create();

        $stat = ReadingStat::create([
            'user_id' => $user->id,
            'year' => 2025,
            'books_read' => 30,
            'pages_read' => 12000,
            'genres_read' => ['philosophy', 'history'],
        ]);

        $this->assertEquals(2025, $stat->year);
        $this->assertEquals(30, $stat->books_read);
        $this->assertEquals(12000, $stat->pages_read);
        $this->assertEquals(['philosophy', 'history'], $stat->genres_read);
        $this->assertTrue($stat->user->is($user));
    }

    /** @test */
    public function it_can_update_fields_correctly()
    {
        $stat = ReadingStat::factory()->create([
            'books_read' => 20,
            'pages_read' => 10000,
        ]);

        $stat->update([
            'books_read' => 50,
            'pages_read' => 20000,
        ]);

        $this->assertEquals(50, $stat->fresh()->books_read);
        $this->assertEquals(20000, $stat->fresh()->pages_read);
    }

    /** @test */
    public function genres_read_defaults_to_array()
    {
        $stat = new ReadingStat([
            'genres_read' => null,
        ]);

        $this->assertNull($stat->genres_read);
    }
}
