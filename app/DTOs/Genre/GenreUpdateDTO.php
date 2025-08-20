<?php

namespace App\DTOs\Genre;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних жанру.
 */
class GenreUpdateDTO
{
    /**
     * Створює новий екземпляр GenreUpdateDTO.
     *
     * @param string|null $name Назва жанру
     * @param string|null $parentId ID батьківського жанру
     * @param string|null $description Опис жанру
     */
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $parentId = null,
        public readonly ?string $description = null,
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
            parentId: $request->input('parent_id'),
            description: $request->input('description'),
        );
    }
}
