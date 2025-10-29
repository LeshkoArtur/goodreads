<?php

namespace App\Data\NominationEntry;

use App\Enums\NominationStatus;
use Illuminate\Http\Request;

readonly class NominationEntryIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
        public ?string $nomination_id = null,
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
            q: $data['q'] ?? null,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? null,
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
            nomination_id: $data['nomination_id'] ?? null,
            book_id: $data['book_id'] ?? null,
            author_id: $data['author_id'] ?? null,
            status: isset($data['status']) ? NominationStatus::from($data['status']) : null,
        );
    }
}
