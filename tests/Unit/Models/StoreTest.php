<?php

namespace Tests\Unit\Models;

use App\Models\BookOffer;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_expected_fillable_fields()
    {
        $store = new Store();
        $this->assertEquals(['name', 'logo_url', 'region', 'website_url'], $store->getFillable());
    }

    /** @test */
    public function it_casts_attributes_properly()
    {
        $store = Store::factory()->create([
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->assertInstanceOf(Carbon::class, $store->created_at);
        $this->assertInstanceOf(Carbon::class, $store->updated_at);
    }

    /** @test */
    public function it_has_many_book_offers()
    {
        $store = Store::factory()->create();
        $offers = BookOffer::factory()->count(3)->for($store)->create();

        $this->assertCount(3, $store->bookOffers);
        $this->assertTrue($store->bookOffers->contains($offers->first()));
    }

    /** @test */
    public function it_can_be_created_with_valid_data()
    {
        $store = Store::create([
            'name' => 'Test Store',
            'logo_url' => 'http://example.com/logo.png',
            'region' => 'Europe',
            'website_url' => 'http://example.com',
        ]);

        $this->assertDatabaseHas('stores', [
            'id' => $store->id,
            'name' => 'Test Store',
            'region' => 'Europe',
        ]);
    }

    /** @test */
    public function it_can_be_updated()
    {
        $store = Store::factory()->create(['name' => 'Old Name']);

        $store->update(['name' => 'New Name']);

        $this->assertEquals('New Name', $store->fresh()->name);
    }

    /** @test */
    public function store_with_no_book_offers_returns_empty_collection()
    {
        $store = Store::factory()->create();

        $this->assertCount(0, $store->bookOffers);
    }
}
