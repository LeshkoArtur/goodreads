<?php

namespace App\Data\Genre;

use Illuminate\Http\Request;

readonly class GenreIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
        public ?string $parent_id = null,
        public ?int $min_book_count = null,
        public ?int $max_book_count = null,
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
            parent_id: $data['parent_id'] ?? null,
            min_book_count: $data['min_book_count'] ?? null,
            max_book_count: $data['max_book_count'] ?? null,
        );
    }
}
