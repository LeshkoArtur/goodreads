<?php

namespace App\DTOs\AuthorQuestion;

use App\Enums\QuestionStatus;
use Illuminate\Http\Request;

/**
 * DTO для оновлення даних питання до автора.
 */
class AuthorQuestionUpdateDTO
{
    /**
     * Створює новий екземпляр AuthorQuestionUpdateDTO.
     *
     * @param string|null $body Текст питання
     * @param string|null $status Статус питання
     */
    public function __construct(
        public readonly ?string $body = null,
        public readonly ?string $status = null,
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
        );
    }
}
