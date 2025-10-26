<?php

namespace App\DTOs\Note;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class NoteUpdateDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly ?string $userId = null,
        public readonly ?string $bookId = null,
        public readonly ?string $text = null,
        public readonly ?int $pageNumber = null,
        public readonly ?bool $containsSpoilers = null,
        public readonly ?bool $isPrivate = null,
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
            text: $data['text'] ?? null,
            pageNumber: isset($data['page_number']) ? (int) $data['page_number'] : null,
            containsSpoilers: isset($data['contains_spoilers']) ? (bool) $data['contains_spoilers'] : null,
            isPrivate: isset($data['is_private']) ? (bool) $data['is_private'] : null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
