<?php

namespace App\DTOs\Store;

use Illuminate\Http\Request;

class StoreStoreDTO
{
    /**
     * @param string $name Назва магазину
     * @param string|null $logoUrl URL логотипу
     * @param string|null $region Регіон
     * @param string|null $websiteUrl URL вебсайту
     */
    public function __construct(
        public readonly string $name,
        public readonly ?string $logoUrl = null,
        public readonly ?string $region = null,
        public readonly ?string $websiteUrl = null
    ) {}

    /**
     * Створити StoreStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            name: $request->input('name'),
            logoUrl: $request->input('logo_url'),
            region: $request->input('region'),
            websiteUrl: $request->input('website_url')
        );
    }
}
