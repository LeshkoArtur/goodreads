<?php

namespace App\DTOs\AuthorAnswer;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\AnswerStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AuthorAnswerUpdateDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly ?string $questionId = null,
        public readonly ?string $authorId = null,
        public readonly ?string $content = null,
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
            questionId: $data['question_id'] ?? null,
            authorId: $data['author_id'] ?? null,
            content: $data['content'] ?? null,
            publishedAt: $data['published_at'] ?? null,
            status: !empty($data['status']) ? AnswerStatus::from($data['status']) : null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
