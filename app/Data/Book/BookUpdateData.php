<?php

namespace App\Data\Book;

use App\Enums\AgeRestriction;
use Illuminate\Http\Request;

readonly class BookUpdateData
{
    public function __construct(
        public ?string $title = null,
        public ?string $description = null,
        public ?string $plot = null,
        public ?string $history = null,
        public ?string $series_id = null,
        public ?int $number_in_series = null,
        public ?int $page_count = null,
        /** @var array<int, string>|null Array of language codes */
        public ?array $languages = null,
        public ?string $cover_image = null,
        /** @var array<int, string>|null Array of fun facts */
        public ?array $fun_facts = null,
        /** @var array<int, string>|null Array of adaptations */
        public ?array $adaptations = null,
        public ?bool $is_bestseller = null,
        public ?float $average_rating = null,
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
            title: $data['title'] ?? null,
            description: $data['description'] ?? null,
            plot: $data['plot'] ?? null,
            history: $data['history'] ?? null,
            series_id: $data['series_id'] ?? null,
            number_in_series: $data['number_in_series'] ?? null,
            page_count: $data['page_count'] ?? null,
            languages: $data['languages'] ?? null,
            cover_image: $data['cover_image'] ?? null,
            fun_facts: $data['fun_facts'] ?? null,
            adaptations: $data['adaptations'] ?? null,
            is_bestseller: $data['is_bestseller'] ?? null,
            average_rating: $data['average_rating'] ?? null,
            age_restriction: isset($data['age_restriction']) ? AgeRestriction::from($data['age_restriction']) : null,
            author_ids: $data['author_ids'] ?? null,
            genre_ids: $data['genre_ids'] ?? null,
            publisher_ids: $data['publisher_ids'] ?? null,
        );
    }
}
