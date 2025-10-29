<?php

namespace App\Actions\Stores;

use App\Enums\OfferStatus;
use App\Models\Store;
use Lorisleiva\Actions\Concerns\AsAction;

class GetStoreStats
{
    use AsAction;

    public function handle(Store $store): array
    {
        return [
            'total_offers' => $store->bookOffers()->count(),
            'active_offers' => $store->bookOffers()->where('status', OfferStatus::ACTIVE)->count(),
            'pending_offers' => $store->bookOffers()->where('status', OfferStatus::PENDING)->count(),
            'inactive_offers' => $store->bookOffers()->where('status', OfferStatus::INACTIVE)->count(),
            'average_price' => $store->bookOffers()
                ->where('status', OfferStatus::ACTIVE)
                ->avg('price'),
            'min_price' => $store->bookOffers()
                ->where('status', OfferStatus::ACTIVE)
                ->min('price'),
            'max_price' => $store->bookOffers()
                ->where('status', OfferStatus::ACTIVE)
                ->max('price'),
        ];
    }
}
