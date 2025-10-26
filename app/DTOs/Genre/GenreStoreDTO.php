<?php

namespace App\DTOs\Genre;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GenreStoreDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly string $name,
        public readonly ?string $parentId = null,
        public readonly ?string $description = null,
        public readonly ?int $bookCount = null,
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
            name: $data['name'],
            parentId: $data['parent_id'] ?? null,
            description: $data['description'] ?? null,
            bookCount: isset($data['book_count']) ? (int) $data['book_count'] : null,
            bookIds: self::processJsonArray($data['book_ids'] ?? null),
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
