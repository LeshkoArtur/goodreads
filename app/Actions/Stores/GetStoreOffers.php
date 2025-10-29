<?php

namespace App\Actions\Stores;

use App\Data\Store\StoreRelationIndexData;
use App\Models\Store;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetStoreOffers
{
    use AsAction;

    public function handle(Store $store, StoreRelationIndexData $data): LengthAwarePaginator
    {
        return $store->bookOffers()
            ->with(['book', 'store'])
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
