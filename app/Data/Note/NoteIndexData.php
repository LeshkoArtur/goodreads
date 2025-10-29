<?php

namespace App\Data\Note;

use Illuminate\Http\Request;

readonly class NoteIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $user_id = null,
        public ?string $book_id = null,
        public ?bool $contains_spoilers = null,
        public ?bool $is_private = null,
        public ?int $min_page_number = null,
        public ?int $max_page_number = null,
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
            user_id: $data['user_id'] ?? null,
            book_id: $data['book_id'] ?? null,
            contains_spoilers: $data['contains_spoilers'] ?? null,
            is_private: $data['is_private'] ?? null,
            min_page_number: $data['min_page_number'] ?? null,
            max_page_number: $data['max_page_number'] ?? null,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? null,
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
        );
    }
}
