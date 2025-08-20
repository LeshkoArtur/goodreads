<?php

namespace App\DTOs\Shelf;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних полиці.
 */
class ShelfUpdateDTO
{
    /**
     * Створює новий екземпляр ShelfUpdateDTO.
     *
     * @param string|null $name Назва полиці
     * @param string|null $type Тип полиці
     * @param bool|null $isPublic Видимість полиці
     */
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $type = null,
        public readonly ?bool $isPublic = null,
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
            type: $request->input('type'),
            isPublic: $request->has('is_public') ? $request->boolean('is_public') : null,
        );
    }
}
