<?php

namespace App\Actions\Stores;

use App\DTOs\Store\StoreUpdateDTO;
use App\Models\Store;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateStore
{
    use AsAction;

    /**
     * Оновити існуючий магазин.
     *
     * @param Store $store
     * @param StoreUpdateDTO $dto
     * @return Store
     */
    public function handle(Store $store, StoreUpdateDTO $dto): Store
    {
        $attributes = [
            'name' => $dto->name,
            'region' => $dto->country,
            'website_url' => $dto->website,
        ];

        $store->fill(array_filter($attributes, fn($value) => $value !== null));

        $store->save();

        return $store->load(['bookOffers']);
    }
}
