<?php

namespace App\DTOs\Group;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\JoinPolicy;
use App\Enums\PostPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GroupStoreDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly string $name,
        public readonly string $creatorId,
        public readonly bool $isPublic = false,
        public readonly ?string $description = null,
        public readonly ?string $coverImage = null,
        public readonly ?string $rules = null,
        public readonly ?int $memberCount = null,
        public readonly bool $isActive = true,
        public readonly ?JoinPolicy $joinPolicy = null,
        public readonly ?PostPolicy $postPolicy = null,
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
            creatorId: $data['creator_id'],
            isPublic: $data['is_public'] ?? false,
            description: $data['description'] ?? null,
            coverImage: $data['cover_image'] ?? null,
            rules: $data['rules'] ?? null,
            memberCount: isset($data['member_count']) ? (int) $data['member_count'] : null,
            isActive: $data['is_active'] ?? true,
            joinPolicy: !empty($data['join_policy']) ? JoinPolicy::from($data['join_policy']) : null,
            postPolicy: !empty($data['post_policy']) ? PostPolicy::from($data['post_policy']) : null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
