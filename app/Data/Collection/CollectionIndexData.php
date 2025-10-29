<?php

namespace App\Data\Collection;

use Illuminate\Http\Request;

readonly class CollectionIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $user_id = null,
        public ?bool $is_public = null,
        /** @var array<int, string>|null */
        public ?array $book_ids = null,
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
            is_public: $data['is_public'] ?? null,
            book_ids: $data['book_ids'] ?? null,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? null,
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
        );
    }
}
