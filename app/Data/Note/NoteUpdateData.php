<?php

namespace App\Data\Note;

use Illuminate\Http\Request;

readonly class NoteUpdateData
{
    public function __construct(
        public ?string $user_id = null,
        public ?string $book_id = null,
        public ?string $text = null,
        public ?int $page_number = null,
        public ?bool $contains_spoilers = null,
        public ?bool $is_private = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'] ?? null,
            book_id: $data['book_id'] ?? null,
            text: $data['text'] ?? null,
            page_number: $data['page_number'] ?? null,
            contains_spoilers: $data['contains_spoilers'] ?? null,
            is_private: $data['is_private'] ?? null,
        );
    }
}
