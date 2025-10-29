<?php

namespace App\Data\AuthorAnswer;

use App\Enums\AnswerStatus;
use Illuminate\Http\Request;

readonly class AuthorAnswerUpdateData
{
    public function __construct(
        public ?string $question_id = null,
        public ?string $author_id = null,
        public ?string $content = null,
        public ?string $published_at = null,
        public ?AnswerStatus $status = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            question_id: $data['question_id'] ?? null,
            author_id: $data['author_id'] ?? null,
            content: $data['content'] ?? null,
            published_at: $data['published_at'] ?? null,
            status: isset($data['status']) ? AnswerStatus::from($data['status']) : null,
        );
    }
}
