<?php

namespace App\Data\BookSeries;

use Illuminate\Http\Request;

readonly class BookSeriesUpdateData
{
    public function __construct(
        public ?string $title = null,
        public ?string $description = null,
        public ?int $total_books = null,
        public ?bool $is_completed = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'] ?? null,
            description: $data['description'] ?? null,
            total_books: $data['total_books'] ?? null,
            is_completed: $data['is_completed'] ?? null,
        );
    }
}
