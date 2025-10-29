<?php

namespace App\Data\GroupPost;

use App\Enums\PostCategory;
use App\Enums\PostStatus;
use Illuminate\Http\Request;

readonly class GroupPostStoreData
{
    public function __construct(
        public string $group_id,
        public string $content,
        public ?bool $is_pinned = false,
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
            group_id: $data['group_id'],
            content: $data['content'],
            is_pinned: $data['is_pinned'] ?? false,
            category: isset($data['category']) ? PostCategory::from($data['category']) : null,
            post_status: isset($data['post_status']) ? PostStatus::from($data['post_status']) : null,
        );
    }
}
