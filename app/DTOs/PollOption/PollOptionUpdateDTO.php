<?php

namespace App\DTOs\PollOption;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних варіанту опитування.
 */
class PollOptionUpdateDTO
{
    /**
     * Створює новий екземпляр PollOptionUpdateDTO.
     *
     * @param string|null $title Назва варіанту
     */
    public function __construct(
        public readonly ?string $title = null,
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
            title: $request->input('title'),
        );
    }
}
