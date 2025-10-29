<?php

namespace App\Data\ReadingStat;

use Illuminate\Http\Request;

readonly class ReadingStatIndexData
{
    public function __construct(
        public ?string $user_id = null,
        public ?int $year = null,
        public ?int $min_books_read = null,
        public ?int $max_books_read = null,
        public ?int $min_pages_read = null,
        public ?int $max_pages_read = null,
        /** @var array<int, string>|null */
        public ?array $genres_read = null,
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
            user_id: $data['user_id'] ?? null,
            year: $data['year'] ?? null,
            min_books_read: $data['min_books_read'] ?? null,
            max_books_read: $data['max_books_read'] ?? null,
            min_pages_read: $data['min_pages_read'] ?? null,
            max_pages_read: $data['max_pages_read'] ?? null,
            genres_read: $data['genres_read'] ?? null,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? null,
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
        );
    }
}
