<?php

namespace App\Data\Comment;

use Illuminate\Http\Request;

readonly class CommentStoreData
{
    public function __construct(
        public string $content,
        public string $commentable_type,
        public string $commentable_id,
        public ?string $parent_id = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            content: $data['content'],
            commentable_type: $data['commentable_type'],
            commentable_id: $data['commentable_id'],
            parent_id: $data['parent_id'] ?? null,
        );
    }
}
