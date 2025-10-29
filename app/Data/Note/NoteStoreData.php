<?php

namespace App\Data\Note;

use Illuminate\Http\Request;

readonly class NoteStoreData
{
    public function __construct(
        public string $user_id,
        public string $book_id,
        public string $text,
        public ?int $page_number = null,
        public ?bool $contains_spoilers = false,
        public ?bool $is_private = false,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            book_id: $data['book_id'],
            text: $data['text'],
            page_number: $data['page_number'] ?? null,
            contains_spoilers: $data['contains_spoilers'] ?? false,
            is_private: $data['is_private'] ?? false,
        );
    }
}
