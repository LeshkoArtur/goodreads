<?php

namespace App\DTOs\NominationEntry;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\NominationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class NominationEntryStoreDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly string $nominationId,
        public readonly string $bookId,
        public readonly string $authorId,
        public readonly ?NominationStatus $status = null,
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
            nominationId: $data['nomination_id'],
            bookId: $data['book_id'],
            authorId: $data['author_id'],
            status: !empty($data['status']) ? NominationStatus::from($data['status']) : null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
