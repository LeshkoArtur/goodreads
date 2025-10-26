<?php

namespace App\DTOs\Publisher;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PublisherStoreDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly string $name,
        public readonly ?string $description = null,
        public readonly ?string $website = null,
        public readonly ?string $country = null,
        public readonly ?int $foundedYear = null,
        public readonly ?string $logo = null,
        public readonly ?string $contactEmail = null,
        public readonly ?string $phone = null,
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
            name: $data['name'],
            description: $data['description'] ?? null,
            website: $data['website'] ?? null,
            country: $data['country'] ?? null,
            foundedYear: isset($data['founded_year']) ? (int) $data['founded_year'] : null,
            logo: $data['logo'] ?? null,
            contactEmail: $data['contact_email'] ?? null,
            phone: $data['phone'] ?? null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
