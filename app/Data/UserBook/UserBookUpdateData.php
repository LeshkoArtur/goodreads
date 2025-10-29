<?php

namespace App\Data\UserBook;

use App\Enums\ReadingFormat;
use Illuminate\Http\Request;

readonly class UserBookUpdateData
{
    public function __construct(
        public ?string $user_id = null,
        public ?string $book_id = null,
        public ?string $shelf_id = null,
        public ?string $start_date = null,
        public ?string $read_date = null,
        public ?int $progress_pages = null,
        public ?bool $is_private = null,
        public ?int $rating = null,
        public ?string $notes = null,
        public ?ReadingFormat $reading_format = null,
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
            shelf_id: $data['shelf_id'] ?? null,
            start_date: $data['start_date'] ?? null,
            read_date: $data['read_date'] ?? null,
            progress_pages: $data['progress_pages'] ?? null,
            is_private: $data['is_private'] ?? null,
            rating: $data['rating'] ?? null,
            notes: $data['notes'] ?? null,
            reading_format: isset($data['reading_format']) ? ReadingFormat::from($data['reading_format']) : null,
        );
    }
}
