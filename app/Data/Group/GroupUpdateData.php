<?php

namespace App\Data\Group;

use App\Enums\JoinPolicy;
use App\Enums\PostPolicy;
use Illuminate\Http\Request;

readonly class GroupUpdateData
{
    public function __construct(
        public ?string $name = null,
        public ?string $creator_id = null,
        public ?string $description = null,
        public ?bool $is_public = null,
        public ?string $cover_image = null,
        public ?string $rules = null,
        public ?int $member_count = null,
        public ?bool $is_active = null,
        public ?JoinPolicy $join_policy = null,
        public ?PostPolicy $post_policy = null,
        /** @var array<int, string>|null Array of member IDs */
        public ?array $member_ids = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            creator_id: $data['creator_id'] ?? null,
            description: $data['description'] ?? null,
            is_public: $data['is_public'] ?? null,
            cover_image: $data['cover_image'] ?? null,
            rules: $data['rules'] ?? null,
            member_count: $data['member_count'] ?? null,
            is_active: $data['is_active'] ?? null,
            join_policy: isset($data['join_policy']) ? JoinPolicy::from($data['join_policy']) : null,
            post_policy: isset($data['post_policy']) ? PostPolicy::from($data['post_policy']) : null,
            member_ids: $data['member_ids'] ?? null,
        );
    }
}
