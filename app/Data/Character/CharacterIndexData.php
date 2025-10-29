<?php

namespace App\Data\Character;

use Illuminate\Http\Request;

readonly class CharacterIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
        public ?string $book_id = null,
        public ?string $race = null,
        public ?string $nationality = null,
        public ?string $residence = null,
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
            book_id: $data['book_id'] ?? null,
            race: $data['race'] ?? null,
            nationality: $data['nationality'] ?? null,
            residence: $data['residence'] ?? null,
        );
    }
}
