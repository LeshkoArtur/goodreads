<?php

namespace App\DTOs\Tag;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних тегу.
 */
class TagUpdateDTO
{
    /**
     * Створює новий екземпляр TagUpdateDTO.
     *
     * @param string|null $name Назва тегу
     */
    public function __construct(
        public readonly ?string $name = null,
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
            name: $request->input('name'),
        );
    }
}
