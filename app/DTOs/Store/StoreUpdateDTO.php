<?php

namespace App\DTOs\Store;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class StoreUpdateDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $logoUrl = null,
        public readonly ?string $region = null,
        public readonly ?string $websiteUrl = null,
        public readonly ?string $country = null,
        public readonly ?string $type = null,
        public readonly ?bool $isOnline = null,
        public readonly array|Collection|null $mediaImages = null,
        public readonly array|Collection|null $socialMediaLinks = null
    ) {}

    public static function fromRequest(Request $request): static
    {
        return self::makeDTO($request->all());
    }

    public static function fromArray(array $data): static
    {
        return self::makeDTO($data);
    }

    private static function makeDTO(array $data): static
    {
        return new static(
            name: $data['name'] ?? null,
            logoUrl: $data['logo_url'] ?? null,
            region: $data['region'] ?? null,
            websiteUrl: $data['website_url'] ?? null,
            country: $data['country'] ?? null,
            type: $data['type'] ?? null,
            isOnline: isset($data['is_online']) ? (bool) $data['is_online'] : null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
