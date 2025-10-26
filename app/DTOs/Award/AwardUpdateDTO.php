<?php

namespace App\DTOs\Award;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AwardUpdateDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly ?string $name = null,
        public readonly ?int $year = null,
        public readonly ?string $description = null,
        public readonly ?string $organizer = null,
        public readonly ?string $country = null,
        public readonly ?string $ceremonyDate = null,
        public readonly ?array $authorIds = null,
        public readonly ?array $bookIds = null,
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
            year: isset($data['year']) ? (int) $data['year'] : null,
            description: $data['description'] ?? null,
            organizer: $data['organizer'] ?? null,
            country: $data['country'] ?? null,
            ceremonyDate: $data['ceremony_date'] ?? null,
            authorIds: self::processJsonArray($data['author_ids'] ?? null),
            bookIds: self::processJsonArray($data['book_ids'] ?? null),
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
