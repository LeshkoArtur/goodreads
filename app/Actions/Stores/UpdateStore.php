<?php

namespace App\Actions\Stores;

use App\Data\Store\StoreUpdateData;
use App\Models\Store;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateStore
{
    use AsAction;

    public function handle(Store $store, StoreUpdateData $data): Store
    {
        $store->update(array_filter([
            'name' => $data->name,
            'logo_url' => $data->logo_url,
            'region' => $data->region,
            'website_url' => $data->website_url,
        ], fn ($value) => $value !== null));

        return $store->fresh(['bookOffers']);
    }
}
