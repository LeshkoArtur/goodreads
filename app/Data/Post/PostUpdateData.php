<?php

namespace App\Data\Post;

use App\Enums\PostStatus;
use App\Enums\PostType;
use Illuminate\Http\Request;

readonly class PostUpdateData
{
    public function __construct(
        public ?string $user_id = null,
        public ?string $title = null,
        public ?string $content = null,
        public ?string $book_id = null,
        public ?string $author_id = null,
        public ?string $cover_image = null,
        public ?string $published_at = null,
        public ?PostType $type = null,
        public ?PostStatus $status = null,
        /** @var array<int, string>|null Array of tag IDs */
        public ?array $tag_ids = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'] ?? null,
            title: $data['title'] ?? null,
            content: $data['content'] ?? null,
            book_id: $data['book_id'] ?? null,
            author_id: $data['author_id'] ?? null,
            cover_image: $data['cover_image'] ?? null,
            published_at: $data['published_at'] ?? null,
            type: isset($data['type']) ? PostType::from($data['type']) : null,
            status: isset($data['status']) ? PostStatus::from($data['status']) : null,
            tag_ids: $data['tag_ids'] ?? null,
        );
    }
}
