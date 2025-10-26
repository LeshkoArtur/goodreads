<?php

namespace App\DTOs\BookSeries;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BookSeriesStoreDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly string $title,
        public readonly ?string $description = null,
        public readonly ?int $totalBooks = null,
        public readonly ?bool $isCompleted = null,
        public readonly ?array $bookIds = null,
        public readonly array|Collection|null $mediaImages = null,
        public readonly array|Collection|null $socialMediaLinks = null
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
            totalBooks: isset($data['total_books']) ? (int) $data['total_books'] : null,
            isCompleted: isset($data['is_completed']) ? (bool) $data['is_completed'] : null,
            bookIds: self::processJsonArray($data['book_ids'] ?? null),
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
