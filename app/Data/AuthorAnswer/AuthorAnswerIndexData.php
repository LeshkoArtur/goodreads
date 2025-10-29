<?php

namespace App\Data\AuthorAnswer;

use App\Enums\AnswerStatus;
use Illuminate\Http\Request;

readonly class AuthorAnswerIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $question_id = null,
        public ?string $author_id = null,
        public ?AnswerStatus $status = null,
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
            question_id: $data['question_id'] ?? null,
            author_id: $data['author_id'] ?? null,
            status: isset($data['status']) ? AnswerStatus::from($data['status']) : null,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? null,
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
        );
    }
}
