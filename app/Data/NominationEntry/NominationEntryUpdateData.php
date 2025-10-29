<?php

namespace App\Data\NominationEntry;

use App\Enums\NominationStatus;
use Illuminate\Http\Request;

readonly class NominationEntryUpdateData
{
    public function __construct(
        public ?string $book_id = null,
        public ?string $author_id = null,
        public ?NominationStatus $status = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            book_id: $data['book_id'] ?? null,
            author_id: $data['author_id'] ?? null,
            status: isset($data['status']) ? NominationStatus::from($data['status']) : null,
        );
    }
}
