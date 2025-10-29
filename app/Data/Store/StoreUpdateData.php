<?php

namespace App\Data\Store;

use Illuminate\Http\Request;

readonly class StoreUpdateData
{
    public function __construct(
        public ?string $name = null,
        public ?string $logo_url = null,
        public ?string $region = null,
        public ?string $website_url = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            logo_url: $data['logo_url'] ?? null,
            region: $data['region'] ?? null,
            website_url: $data['website_url'] ?? null,
        );
    }
}
