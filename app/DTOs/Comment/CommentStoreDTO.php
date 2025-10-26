<?php

namespace App\DTOs\Comment;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CommentStoreDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly string $userId,
        public readonly string $commentableType,
        public readonly string $commentableId,
        public readonly string $content,
        public readonly ?string $parentId = null,
        public readonly ?bool $isSpoiler = null,
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
            commentableType: $data['commentable_type'],
            commentableId: $data['commentable_id'],
            content: $data['content'],
            parentId: $data['parent_id'] ?? null,
            isSpoiler: isset($data['is_spoiler']) ? (bool) $data['is_spoiler'] : null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
