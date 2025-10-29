<?php

namespace App\Data\Collection;

use Illuminate\Http\Request;

readonly class CollectionStoreData
{
    public function __construct(
        public string $user_id,
        public string $title,
        public ?string $description = null,
        public ?string $cover_image = null,
        public ?bool $is_public = true,
        /** @var array<int, string>|null Array of book IDs */
        public ?array $book_ids = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            title: $data['title'],
            description: $data['description'] ?? null,
            cover_image: $data['cover_image'] ?? null,
            is_public: $data['is_public'] ?? true,
            book_ids: $data['book_ids'] ?? null,
        );
    }
}
