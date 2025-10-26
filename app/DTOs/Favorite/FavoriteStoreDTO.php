<?php

namespace App\DTOs\Favorite;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FavoriteStoreDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly string $userId,
        public readonly string $favoriteableId,
        public readonly string $favoriteableType,
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
            userId: $data['user_id'],
            favoriteableId: $data['favoriteable_id'],
            favoriteableType: $data['favoriteable_type'],
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
