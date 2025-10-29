<?php

namespace Tests\Unit\Models;

use App\Enums\Currency;
use App\Enums\OfferStatus;
use App\Models\Book;
use App\Models\BookOffer;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class BookOfferTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_offer_with_valid_data()
    {
        $offer = BookOffer::factory()->create();

        $this->assertDatabaseHas('book_offers', [
            'id' => $offer->id,
        ]);

        $this->assertInstanceOf(Currency::class, $offer->currency);
        $this->assertInstanceOf(OfferStatus::class, $offer->status);
        $this->assertNotNull($offer->book);
        $this->assertNotNull($offer->store);
    }

    /** @test */
    public function it_requires_mandatory_fields()
    {
        $data = [];

        $validator = Validator::make($data, [
            'book_id' => 'required|uuid|exists:books,id',
            'store_id' => 'required|uuid|exists:stores,id',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|in:'.implode(',', array_column(Currency::cases(), 'value')),
            'status' => 'required|in:'.implode(',', array_column(OfferStatus::cases(), 'value')),
            'last_updated_at' => 'required|date',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertCount(6, $validator->errors());
    }

    /** @test */
    public function it_casts_enum_attributes()
    {
        $offer = BookOffer::factory()->create([
            'currency' => Currency::UAH,
            'status' => OfferStatus::ACTIVE,
        ]);

        $this->assertEquals(Currency::UAH, $offer->currency);
        $this->assertEquals(OfferStatus::ACTIVE, $offer->status);
    }

    /** @test */
    public function it_has_book_relation()
    {
        $offer = BookOffer::factory()->create();

        $this->assertInstanceOf(Book::class, $offer->book);
    }

    /** @test */
    public function it_has_store_relation()
    {
        $offer = BookOffer::factory()->create();

        $this->assertInstanceOf(Store::class, $offer->store);
    }

    /** @test */
    public function price_must_be_non_negative()
    {
        $data = BookOffer::factory()->make([
            'price' => -10,
        ])->toArray();

        $validator = Validator::make($data, [
            'price' => 'required|numeric|min:0',
        ]);

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function test_last_updated_at_invalid_through_factory()
    {
        $data = BookOffer::factory()->make()->toArray();
        $data['last_updated_at'] = 'invalid-date';

        $validator = Validator::make($data, [
            'last_updated_at' => 'required|date',
        ]);

        $this->assertTrue($validator->fails());
    }
}
