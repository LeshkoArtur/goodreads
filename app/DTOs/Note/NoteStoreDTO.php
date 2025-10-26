<?php

namespace App\DTOs\Note;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class NoteStoreDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly string $userId,
        public readonly string $bookId,
        public readonly string $text,
        public readonly ?int $pageNumber = null,
        public readonly bool $containsSpoilers = false,
        public readonly bool $isPrivate = false,
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
            userId: $data['user_id'],
            bookId: $data['book_id'],
            text: $data['text'],
            pageNumber: isset($data['page_number']) ? (int) $data['page_number'] : null,
            containsSpoilers: $data['contains_spoilers'] ?? false,
            isPrivate: $data['is_private'] ?? false,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
