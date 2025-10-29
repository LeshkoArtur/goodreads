<?php

namespace App\Data\Genre;

use Illuminate\Http\Request;

readonly class GenreUpdateData
{
    public function __construct(
        public ?string $name = null,
        public ?string $parent_id = null,
        public ?string $description = null,
        public ?int $book_count = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            parent_id: $data['parent_id'] ?? null,
            description: $data['description'] ?? null,
            book_count: $data['book_count'] ?? null,
        );
    }
}
