<?php

namespace App\Http\Resources;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Store
 */
class StoreResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo_url' => $this->logo_url,
            'region' => $this->region,
            'website_url' => $this->website_url,
            'book_offers' => $this->whenLoaded('bookOffers', function () {
                return $this->bookOffers->map(fn ($offer) => [
                    'id' => $offer->id,
                    'book_id' => $offer->book_id,
                    'price' => $offer->price,
                    'currency' => $offer->currency?->value,
                    'status' => $offer->status?->value,
                ]);
            }),
            'offers_count' => $this->whenCounted('bookOffers'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
