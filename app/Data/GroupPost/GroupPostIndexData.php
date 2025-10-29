<?php

namespace App\Data\GroupPost;

use App\Enums\PostCategory;
use App\Enums\PostStatus;
use Illuminate\Http\Request;

readonly class GroupPostIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
        public ?string $group_id = null,
        public ?string $user_id = null,
        public ?bool $is_pinned = null,
        public ?PostCategory $category = null,
        public ?PostStatus $post_status = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            q: $data['q'] ?? null,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? null,
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
            group_id: $data['group_id'] ?? null,
            user_id: $data['user_id'] ?? null,
            is_pinned: isset($data['is_pinned']) ? (bool) $data['is_pinned'] : null,
            category: isset($data['category']) ? PostCategory::from($data['category']) : null,
            post_status: isset($data['post_status']) ? PostStatus::from($data['post_status']) : null,
        );
    }
}
