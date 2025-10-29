<?php

namespace App\Data\NominationEntry;

use Illuminate\Http\Request;

readonly class NominationEntryStoreData
{
    public function __construct(
        public string $nomination_id,
        public ?string $book_id = null,
        public ?string $author_id = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            nomination_id: $data['nomination_id'],
            book_id: $data['book_id'] ?? null,
            author_id: $data['author_id'] ?? null,
        );
    }
}
