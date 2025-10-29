<?php

namespace App\Data\Comment;

use Illuminate\Http\Request;

readonly class CommentIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
        public ?string $user_id = null,
        public ?string $commentable_type = null,
        public ?string $commentable_id = null,
        public ?string $parent_id = null,
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
            user_id: $data['user_id'] ?? null,
            commentable_type: $data['commentable_type'] ?? null,
            commentable_id: $data['commentable_id'] ?? null,
            parent_id: $data['parent_id'] ?? null,
        );
    }
}
