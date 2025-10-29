<?php

namespace App\Data\Book;

use App\Enums\AgeRestriction;
use Illuminate\Http\Request;

readonly class BookIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
        public ?string $series_id = null,
        public ?int $min_page_count = null,
        public ?int $max_page_count = null,
        /** @var array<int, string>|null Array of language codes */
        public ?array $languages = null,
        public ?bool $is_bestseller = null,
        public ?float $min_average_rating = null,
        public ?float $max_average_rating = null,
        public ?AgeRestriction $age_restriction = null,
        /** @var array<int, string>|null Array of author IDs */
        public ?array $author_ids = null,
        /** @var array<int, string>|null Array of genre IDs */
        public ?array $genre_ids = null,
        /** @var array<int, string>|null Array of publisher IDs */
        public ?array $publisher_ids = null,
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
            series_id: $data['series_id'] ?? null,
            min_page_count: $data['min_page_count'] ?? null,
            max_page_count: $data['max_page_count'] ?? null,
            languages: $data['languages'] ?? null,
            is_bestseller: $data['is_bestseller'] ?? null,
            min_average_rating: $data['min_average_rating'] ?? null,
            max_average_rating: $data['max_average_rating'] ?? null,
            age_restriction: isset($data['age_restriction']) ? AgeRestriction::from($data['age_restriction']) : null,
            author_ids: $data['author_ids'] ?? null,
            genre_ids: $data['genre_ids'] ?? null,
            publisher_ids: $data['publisher_ids'] ?? null,
        );
    }
}
