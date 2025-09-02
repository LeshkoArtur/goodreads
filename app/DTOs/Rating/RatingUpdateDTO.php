<?php

namespace App\DTOs\Rating;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних рейтингу.
 */
class RatingUpdateDTO
{
    /**
     * Створює новий екземпляр RatingUpdateDTO.
     *
     * @param int|null $score Бал рейтингу
     */
    public function __construct(
        public readonly ?int $score = null,
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
            score: $request->input('score') ? (int) $request->input('score') : null,
        );
    }
}
