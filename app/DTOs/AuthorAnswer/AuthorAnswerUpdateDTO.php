<?php

namespace App\DTOs\AuthorAnswer;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних відповіді автора.
 */
class AuthorAnswerUpdateDTO
{
    /**
     * Створює новий екземпляр AuthorAnswerUpdateDTO.
     *
     * @param string|null $body Текст відповіді
     * @param string|null $status Статус відповіді
     * @param string|null $publishedAt Дата публікації
     */
    public function __construct(
        public readonly ?string $body = null,
        public readonly ?string $status = null,
        public readonly ?string $publishedAt = null,
    ) {
    }

    /**
     * Створює новий екземпляр DTO з запиту.
     *
     * @param Request $request HTTP-запит
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            body: $request->input('body'),
            status: $request->input('status'),
            publishedAt: $request->input('published_at'),
        );
    }
}
