<?php

namespace App\DTOs\Collection;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CollectionUpdateDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly ?string $userId = null,
        public readonly ?string $title = null,
        public readonly ?string $description = null,
        public readonly ?string $coverImage = null,
        public readonly ?bool $isPublic = null,
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
            userId: $data['user_id'] ?? null,
            title: $data['title'] ?? null,
            description: $data['description'] ?? null,
            coverImage: $data['cover_image'] ?? null,
            isPublic: isset($data['is_public']) ? (bool) $data['is_public'] : null,
            bookIds: self::processJsonArray($data['book_ids'] ?? null),
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
