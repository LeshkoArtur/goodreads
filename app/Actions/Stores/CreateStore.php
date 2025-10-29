<?php

namespace App\Actions\Stores;

use App\Data\Store\StoreStoreData;
use App\Models\Store;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateStore
{
    use AsAction;

    public function handle(StoreStoreData $data): Store
    {
        $store = new Store;
        $store->name = $data->name;
        $store->logo_url = $data->logo_url;
        $store->region = $data->region;
        $store->website_url = $data->website_url;
        $store->save();

        return $store->fresh(['bookOffers']);
    }
}
