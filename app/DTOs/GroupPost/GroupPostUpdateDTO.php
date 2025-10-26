<?php

namespace App\DTOs\GroupPost;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\PostCategory;
use App\Enums\PostStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GroupPostUpdateDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly ?string $groupId = null,
        public readonly ?string $creatorId = null,
        public readonly ?string $title = null,
        public readonly ?string $body = null,
        public readonly ?bool $isPinned = null,
        public readonly ?PostCategory $category = null,
        public readonly ?PostStatus $status = null,
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
            groupId: $data['group_id'] ?? null,
            creatorId: $data['creator_id'] ?? null,
            title: $data['title'] ?? null,
            body: $data['body'] ?? null,
            isPinned: isset($data['is_pinned']) ? (bool) $data['is_pinned'] : null,
            category: !empty($data['category']) ? PostCategory::from($data['category']) : null,
            status: !empty($data['status']) ? PostStatus::from($data['status']) : null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
