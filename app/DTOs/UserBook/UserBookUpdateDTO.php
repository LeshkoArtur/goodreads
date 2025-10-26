<?php

namespace App\DTOs\UserBook;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\ReadingFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserBookUpdateDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly ?string $userId = null,
        public readonly ?string $bookId = null,
        public readonly ?string $shelfId = null,
        public readonly ?string $startDate = null,
        public readonly ?string $readDate = null,
        public readonly ?int $progressPages = null,
        public readonly ?bool $isPrivate = null,
        public readonly ?int $rating = null,
        public readonly ?string $notes = null,
        public readonly ?ReadingFormat $readingFormat = null,
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
            bookId: $data['book_id'] ?? null,
            shelfId: $data['shelf_id'] ?? null,
            startDate: $data['start_date'] ?? null,
            readDate: $data['read_date'] ?? null,
            progressPages: isset($data['progress_pages']) ? (int) $data['progress_pages'] : null,
            isPrivate: isset($data['is_private']) ? (bool) $data['is_private'] : null,
            rating: isset($data['rating']) ? (int) $data['rating'] : null,
            notes: $data['notes'] ?? null,
            readingFormat: !empty($data['reading_format']) ? ReadingFormat::from($data['reading_format']) : null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
