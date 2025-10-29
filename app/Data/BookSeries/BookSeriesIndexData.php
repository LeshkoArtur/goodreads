<?php

namespace App\Data\BookSeries;

use Illuminate\Http\Request;

readonly class BookSeriesIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?bool $is_completed = null,
        public ?int $min_total_books = null,
        public ?int $max_total_books = null,
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
            is_completed: $data['is_completed'] ?? null,
            min_total_books: $data['min_total_books'] ?? null,
            max_total_books: $data['max_total_books'] ?? null,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? null,
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
        );
    }
}
