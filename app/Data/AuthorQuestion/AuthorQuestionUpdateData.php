<?php

namespace App\Data\AuthorQuestion;

use App\Enums\QuestionStatus;
use Illuminate\Http\Request;

readonly class AuthorQuestionUpdateData
{
    public function __construct(
        public ?string $user_id = null,
        public ?string $author_id = null,
        public ?string $content = null,
        public ?string $book_id = null,
        public ?QuestionStatus $status = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'] ?? null,
            author_id: $data['author_id'] ?? null,
            content: $data['content'] ?? null,
            book_id: $data['book_id'] ?? null,
            status: isset($data['status']) ? QuestionStatus::from($data['status']) : null,
        );
    }
}
