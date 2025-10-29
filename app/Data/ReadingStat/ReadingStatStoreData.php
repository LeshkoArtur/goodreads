<?php

namespace App\Data\ReadingStat;

use Illuminate\Http\Request;

readonly class ReadingStatStoreData
{
    public function __construct(
        public string $user_id,
        public int $year,
        public int $books_read,
        public int $pages_read,
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
            user_id: $data['user_id'],
            year: $data['year'],
            books_read: $data['books_read'],
            pages_read: $data['pages_read'],
            genres_read: $data['genres_read'] ?? null,
        );
    }
}
