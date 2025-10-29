<?php

namespace App\Actions\Stores;

use App\Data\Store\StoreRelationIndexData;
use App\Enums\OfferStatus;
use App\Models\Store;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetStoreActiveOffers
{
    use AsAction;

    public function handle(Store $store, StoreRelationIndexData $data): LengthAwarePaginator
    {
        return $store->bookOffers()
            ->where('status', OfferStatus::ACTIVE)
            ->with(['book', 'store'])
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
