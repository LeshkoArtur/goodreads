<?php

namespace App\Data\Post;

use App\Enums\PostStatus;
use App\Enums\PostType;
use Illuminate\Http\Request;

readonly class PostIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $user_id = null,
        public ?string $book_id = null,
        public ?string $author_id = null,
        public ?PostType $type = null,
        public ?PostStatus $status = null,
        /** @var array<int, string>|null */
        public ?array $tag_ids = null,
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
            user_id: $data['user_id'] ?? null,
            book_id: $data['book_id'] ?? null,
            author_id: $data['author_id'] ?? null,
            type: isset($data['type']) ? PostType::from($data['type']) : null,
            status: isset($data['status']) ? PostStatus::from($data['status']) : null,
            tag_ids: $data['tag_ids'] ?? null,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? null,
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
        );
    }
}
