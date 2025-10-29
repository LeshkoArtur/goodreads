<?php

namespace App\Data\UserBook;

use App\Enums\ReadingFormat;
use Illuminate\Http\Request;

readonly class UserBookIndexData
{
    public function __construct(
        public ?string $user_id = null,
        public ?string $book_id = null,
        public ?string $shelf_id = null,
        public ?bool $is_private = null,
        public ?int $min_rating = null,
        public ?int $max_rating = null,
        public ?ReadingFormat $reading_format = null,
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
            user_id: $data['user_id'] ?? null,
            book_id: $data['book_id'] ?? null,
            shelf_id: $data['shelf_id'] ?? null,
            is_private: $data['is_private'] ?? null,
            min_rating: $data['min_rating'] ?? null,
            max_rating: $data['max_rating'] ?? null,
            reading_format: isset($data['reading_format']) ? ReadingFormat::from($data['reading_format']) : null,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? null,
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
        );
    }
}
