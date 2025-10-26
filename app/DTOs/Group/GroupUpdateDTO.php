<?php

namespace App\DTOs\Group;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\JoinPolicy;
use App\Enums\PostPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GroupUpdateDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $creatorId = null,
        public readonly ?bool $isPublic = null,
        public readonly ?string $description = null,
        public readonly ?string $coverImage = null,
        public readonly ?string $rules = null,
        public readonly ?int $memberCount = null,
        public readonly ?bool $isActive = null,
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
            name: $data['name'] ?? null,
            creatorId: $data['creator_id'] ?? null,
            isPublic: isset($data['is_public']) ? (bool) $data['is_public'] : null,
            description: $data['description'] ?? null,
            coverImage: $data['cover_image'] ?? null,
            rules: $data['rules'] ?? null,
            memberCount: isset($data['member_count']) ? (int) $data['member_count'] : null,
            isActive: isset($data['is_active']) ? (bool) $data['is_active'] : null,
            joinPolicy: !empty($data['join_policy']) ? JoinPolicy::from($data['join_policy']) : null,
            postPolicy: !empty($data['post_policy']) ? PostPolicy::from($data['post_policy']) : null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
