<?php

namespace App\DTOs\ReadingStat;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ReadingStatUpdateDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly ?string $userId = null,
        public readonly ?int $year = null,
        public readonly ?int $booksRead = null,
        public readonly ?int $pagesRead = null,
        public readonly ?array $genresRead = null,
        public readonly ?string $status = null,
        public readonly ?string $startDate = null,
        public readonly ?string $finishDate = null,
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
            userId: $data['user_id'] ?? null,
            year: isset($data['year']) ? (int) $data['year'] : null,
            booksRead: isset($data['books_read']) ? (int) $data['books_read'] : null,
            pagesRead: isset($data['pages_read']) ? (int) $data['pages_read'] : null,
            genresRead: self::processJsonArray($data['genres_read'] ?? null),
            status: $data['status'] ?? null,
            startDate: $data['start_date'] ?? null,
            finishDate: $data['finish_date'] ?? null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
