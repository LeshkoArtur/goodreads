<?php

namespace App\DTOs\Collection;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних колекції.
 */
class CollectionUpdateDTO
{
    /**
     * Створює новий екземпляр CollectionUpdateDTO.
     *
     * @param string|null $name Назва колекції
     * @param bool|null $isPublic Видимість колекції
     * @param string|null $description Опис колекції
     */
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?bool $isPublic = null,
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
            isPublic: $request->has('is_public') ? $request->boolean('is_public') : null,
            description: $request->input('description'),
        );
    }
}
