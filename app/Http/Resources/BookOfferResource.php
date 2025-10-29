<?php

namespace App\Http\Resources;

use App\Models\BookOffer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin BookOffer
 */
class BookOfferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'book_id' => $this->book_id,
            'store_id' => $this->store_id,
            'price' => $this->price,
            'currency' => $this->currency?->value,
            'referral_url' => $this->referral_url,
            'availability' => $this->availability,
            'status' => $this->status?->value,
            'last_updated_at' => $this->last_updated_at,
            'book' => $this->whenLoaded('book', function () {
                return [
                    'id' => $this->book->id,
                    'title' => $this->book->title,
                    'slug' => $this->book->slug ?? null,
                ];
            }),
            'store' => $this->whenLoaded('store', function () {
                return [
                    'id' => $this->store->id,
                    'name' => $this->store->name,
                    'logo_url' => $this->store->logo_url,
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
