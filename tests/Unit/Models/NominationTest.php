<?php

namespace Tests\Unit\Models;

use App\Models\Award;
use App\Models\Nomination;
use App\Models\NominationEntry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class NominationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_expected_fillable_fields()
    {
        $nomination = new Nomination;

        $this->assertEquals([
            'award_id',
            'name',
            'description',
        ], $nomination->getFillable());
    }

    /** @test */
    public function it_uses_expected_table_name()
    {
        $nomination = new Nomination;

        $this->assertEquals('nominations', $nomination->getTable());
    }

    /** @test */
    public function it_has_uuid_as_primary_key()
    {
        $nomination = new Nomination;

        $this->assertEquals('id', $nomination->getKeyName());
        $this->assertFalse($nomination->getIncrementing());
        $this->assertEquals('string', $nomination->getKeyType());
    }

    /** @test */
    public function it_belongs_to_an_award()
    {
        $award = Award::factory()->create();
        $nomination = Nomination::factory()->create(['award_id' => $award->id]);

        $this->assertInstanceOf(Award::class, $nomination->award);
        $this->assertTrue($nomination->award->is($award));
    }

    /** @test */
    public function it_has_many_entries()
    {
        $nomination = Nomination::factory()->create();
        $entries = NominationEntry::factory()->count(3)->create([
            'nomination_id' => $nomination->id,
        ]);

        $this->assertCount(3, $nomination->entries);
        $this->assertInstanceOf(NominationEntry::class, $nomination->entries->first());
    }

    /** @test */
    public function it_can_lazy_load_award()
    {
        $nomination = Nomination::factory()->create();

        $this->assertInstanceOf(Award::class, $nomination->award);
    }

    /** @test */
    public function it_can_eager_load_entries()
    {
        $nomination = Nomination::factory()
            ->has(NominationEntry::factory()->count(2), 'entries')
            ->create();

        $nomination->load('entries');

        $this->assertTrue($nomination->relationLoaded('entries'));
        $this->assertCount(2, $nomination->entries);
    }

    /** @test */
    public function it_can_be_created_with_factory()
    {
        $nomination = Nomination::factory()->create();

        $this->assertDatabaseHas('nominations', [
            'id' => $nomination->id,
            'name' => $nomination->name,
        ]);
    }

    /** @test */
    public function it_generates_uuid_on_creation()
    {
        $nomination = Nomination::factory()->create();

        $this->assertTrue(Str::isUuid($nomination->id));
    }
}
