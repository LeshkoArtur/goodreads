<?php

namespace App\DTOs\AuthorQuestion;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\QuestionStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AuthorQuestionStoreDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly string $userId,
        public readonly string $authorId,
        public readonly string $content,
        public readonly ?string $bookId = null,
        public readonly ?QuestionStatus $status = null,
        public readonly ?array $mediaImages = null,
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
            authorId: $data['author_id'],
            content: $data['content'],
            bookId: $data['book_id'] ?? null,
            status: !empty($data['status']) ? QuestionStatus::from($data['status']) : null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
