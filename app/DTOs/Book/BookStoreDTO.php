<?php

namespace App\DTOs\Book;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\AgeRestriction;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BookStoreDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly string $title,
        public readonly ?string $description = null,
        public readonly ?string $plot = null,
        public readonly ?string $history = null,
        public readonly ?string $seriesId = null,
        public readonly ?int $numberInSeries = null,
        public readonly ?int $pageCount = null,
        public readonly array|Collection|null $languages = null,
        public readonly ?string $coverImage = null,
        public readonly array|Collection|null $funFacts = null,
        public readonly array|Collection|null $adaptations = null,
        public readonly bool $isBestseller = false,
        public readonly ?float $averageRating = null,
        public readonly ?AgeRestriction $ageRestriction = null,
        public readonly ?array $authorIds = null,
        public readonly ?array $genreIds = null,
        public readonly ?array $publisherIds = null
    ) {}

    public static function fromRequest(Request $request): static
    {
        return self::makeDTO($request->all());
    }

    public static function fromArray(array $data): static
    {
        return self::makeDTO($data);
    }

    private static function makeDTO(array $data): static
    {
        return new static(
            title: $data['title'],
            description: $data['description'] ?? null,
            plot: $data['plot'] ?? null,
            history: $data['history'] ?? null,
            seriesId: $data['series_id'] ?? null,
            numberInSeries: isset($data['number_in_series']) ? (int) $data['number_in_series'] : null,
            pageCount: isset($data['page_count']) ? (int) $data['page_count'] : null,
            languages: self::processJsonArray($data['languages'] ?? null),
            coverImage: $data['cover_image'] ?? null,
            funFacts: self::processJsonArray($data['fun_facts'] ?? null),
            adaptations: self::processJsonArray($data['adaptations'] ?? null),
            isBestseller: $data['is_bestseller'] ?? false,
            averageRating: isset($data['average_rating']) ? (float) $data['average_rating'] : null,
            ageRestriction: !empty($data['age_restriction']) ? AgeRestriction::from($data['age_restriction']) : null,
            authorIds: self::processJsonArray($data['author_ids'] ?? null),
            genreIds: self::processJsonArray($data['genre_ids'] ?? null),
            publisherIds: self::processJsonArray($data['publisher_ids'] ?? null)
        );
    }
}
