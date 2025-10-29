<?php

namespace App\Data\AuthorAnswer;

use App\Enums\AnswerStatus;
use Illuminate\Http\Request;

readonly class AuthorAnswerStoreData
{
    public function __construct(
        public string $question_id,
        public string $author_id,
        public string $content,
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
            question_id: $data['question_id'],
            author_id: $data['author_id'],
            content: $data['content'],
            published_at: $data['published_at'] ?? null,
            status: isset($data['status']) ? AnswerStatus::from($data['status']) : null,
        );
    }
}
