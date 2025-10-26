<?php

namespace App\DTOs\Rating;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class RatingUpdateDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly ?string $userId = null,
        public readonly ?string $bookId = null,
        public readonly ?int $rating = null,
        public readonly ?string $review = null,
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
            rating: isset($data['rating']) ? (int) $data['rating'] : null,
            review: $data['review'] ?? null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
