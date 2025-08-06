<?php

namespace Tests\Unit\Models;

use App\Models\Award;
use App\Models\Nomination;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AwardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_created_with_valid_data()
    {
        $award = Award::factory()->create([
            'name' => 'Golden Book Award',
            'year' => 2024,
            'description' => 'Prestigious book award.',
            'organizer' => 'Book World',
            'country' => 'USA',
            'ceremony_date' => now()->addDays(10)->toDateString(),
        ]);

        $this->assertDatabaseHas('awards', [
            'id' => $award->id,
            'name' => 'Golden Book Award',
        ]);

        $this->assertEquals(2024, $award->year);
        $this->assertEquals('Book World', $award->organizer);
        $this->assertEquals('USA', $award->country);
        $this->assertNotNull($award->ceremony_date);
    }

    /** @test */
    public function it_casts_year_and_ceremony_date_correctly()
    {
        $award = Award::factory()->create([
            'year' => 2000,
            'ceremony_date' => '2025-12-01',
        ]);

        $this->assertIsInt($award->year);
        $this->assertEquals(2000, $award->year);

        $this->assertEquals('2025-12-01', $award->ceremony_date->toDateString());
    }

    /** @test */
    public function it_has_many_nominations()
    {
        $award = Award::factory()->create();
        $nominations = Nomination::factory()->count(3)->create([
            'award_id' => $award->id,
        ]);

        $this->assertCount(3, $award->nominations);
        $this->assertTrue($award->nominations->first() instanceof Nomination);
    }

    /** @test */
    public function it_can_be_updated()
    {
        $award = Award::factory()->create();

        $award->update([
            'organizer' => 'Updated Org',
        ]);

        $this->assertEquals('Updated Org', $award->fresh()->organizer);
    }

    /** @test */
    public function it_can_be_deleted()
    {
        $award = Award::factory()->create();

        $award->delete();

        $this->assertDatabaseMissing('awards', ['id' => $award->id]);
    }

    /** @test */
    public function it_fails_with_invalid_year()
    {
        $this->expectException(QueryException::class);

        Award::factory()->create(['year' => 'not-a-year']);
    }

    /** @test */
    public function it_fails_with_invalid_date_format()
    {
        $this->expectException(InvalidFormatException::class);

        Award::factory()->create(['ceremony_date' => 'not-a-date']);
    }
}
