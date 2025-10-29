<?php

namespace App\Data\Group;

use App\Enums\JoinPolicy;
use App\Enums\PostPolicy;
use Illuminate\Http\Request;

readonly class GroupIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $creator_id = null,
        public ?bool $is_public = null,
        public ?bool $is_active = null,
        public ?JoinPolicy $join_policy = null,
        public ?PostPolicy $post_policy = null,
        public ?int $min_member_count = null,
        public ?int $max_member_count = null,
        /** @var array<int, string>|null */
        public ?array $member_ids = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            q: $data['q'] ?? null,
            creator_id: $data['creator_id'] ?? null,
            is_public: $data['is_public'] ?? null,
            is_active: $data['is_active'] ?? null,
            join_policy: isset($data['join_policy']) ? JoinPolicy::from($data['join_policy']) : null,
            post_policy: isset($data['post_policy']) ? PostPolicy::from($data['post_policy']) : null,
            min_member_count: $data['min_member_count'] ?? null,
            max_member_count: $data['max_member_count'] ?? null,
            member_ids: $data['member_ids'] ?? null,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? null,
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
        );
    }
}
