<?php

namespace App\Actions\Stores;

use App\DTOs\Store\StoreStoreDTO;
use App\Models\Store;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateStore
{
    use AsAction;

    /**
     * Створити новий магазин.
     *
     * @param StoreStoreDTO $dto
     * @return Store
     */
    public function handle(StoreStoreDTO $dto): Store
    {
        $store = new Store();
        $store->name = $dto->name;
        $store->logo_url = $dto->logoUrl;
        $store->region = $dto->region;
        $store->website_url = $dto->websiteUrl;

        if ($dto->logoUrl) {
            $store->logo_url = $store->handleFileUpload($dto->logoUrl, 'store_logos');
        }

        $store->save();

        return $store->load(['bookOffers']);
    }
}
