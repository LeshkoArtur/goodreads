<?php

namespace App\Data\ReadingStat;

use Illuminate\Http\Request;

readonly class ReadingStatUpdateData
{
    public function __construct(
        public ?string $user_id = null,
        public ?int $year = null,
        public ?int $books_read = null,
        public ?int $pages_read = null,
        /** @var array<int, string>|null */
        public ?array $genres_read = null,
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
            books_read: $data['books_read'] ?? null,
            pages_read: $data['pages_read'] ?? null,
            genres_read: $data['genres_read'] ?? null,
        );
    }
}
