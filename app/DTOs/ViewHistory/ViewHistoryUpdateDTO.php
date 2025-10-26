<?php

namespace App\DTOs\ViewHistory;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ViewHistoryUpdateDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly ?string $userId = null,
        public readonly ?string $viewableId = null,
        public readonly ?string $viewableType = null,
        public readonly ?string $viewedAt = null,
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
            viewableId: $data['viewable_id'] ?? null,
            viewableType: $data['viewable_type'] ?? null,
            viewedAt: $data['viewed_at'] ?? null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
