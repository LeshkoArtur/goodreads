<?php

namespace App\DTOs\AuthorAnswer;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\AnswerStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AuthorAnswerStoreDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly string $questionId,
        public readonly string $authorId,
        public readonly string $content,
        public readonly ?string $publishedAt = null,
        public readonly ?AnswerStatus $status = null,
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
            questionId: $data['question_id'],
            authorId: $data['author_id'],
            content: $data['content'],
            publishedAt: $data['published_at'] ?? null,
            status: !empty($data['status']) ? AnswerStatus::from($data['status']) : null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
