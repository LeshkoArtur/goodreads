<?php

namespace App\Data\BookSeries;

use Illuminate\Http\Request;

readonly class BookSeriesStoreData
{
    public function __construct(
        public string $title,
        public ?string $description = null,
        public ?int $total_books = 0,
        public ?bool $is_completed = false,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'] ?? null,
            total_books: $data['total_books'] ?? 0,
            is_completed: $data['is_completed'] ?? false,
        );
    }
}
