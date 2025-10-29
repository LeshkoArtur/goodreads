<?php

namespace App\Data\AuthorQuestion;

use App\Enums\QuestionStatus;
use Illuminate\Http\Request;

readonly class AuthorQuestionIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $user_id = null,
        public ?string $author_id = null,
        public ?string $book_id = null,
        public ?QuestionStatus $status = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            q: $data['q'] ?? null,
            user_id: $data['user_id'] ?? null,
            author_id: $data['author_id'] ?? null,
            book_id: $data['book_id'] ?? null,
            status: isset($data['status']) ? QuestionStatus::from($data['status']) : null,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? null,
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
        );
    }
}
