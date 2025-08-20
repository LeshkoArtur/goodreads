<?php

namespace App\DTOs\AuthorAnswer;

use App\Enums\AnswerStatus;
use Illuminate\Http\Request;

class AuthorAnswerStoreDTO
{
    /**
     * @param string $questionId ID питання
     * @param string $authorId ID автора
     * @param string $content Текст відповіді
     * @param string|null $publishedAt Дата публікації у форматі Y-m-d H:i:s
     * @param AnswerStatus|null $status Статус відповіді
     */
    public function __construct(
        public readonly string $questionId,
        public readonly string $authorId,
        public readonly string $content,
        public readonly ?string $publishedAt = null,
        public readonly ?AnswerStatus $status = null
    ) {}

    /**
     * Створити AuthorAnswerStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            questionId: $request->input('question_id'),
            authorId: $request->input('author_id'),
            content: $request->input('content'),
            publishedAt: $request->input('published_at'),
            status: $request->input('status')
                ? AnswerStatus::from($request->input('status'))
                : null
        );
    }
}
