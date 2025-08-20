<?php

namespace App\DTOs\Nomination;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних номінації.
 */
class NominationUpdateDTO
{
    /**
     * Створює новий екземпляр NominationUpdateDTO.
     *
     * @param string|null $name Назва номінації
     * @param string|null $description Опис номінації
     */
    public function __construct(
        public readonly ?string $name = null,
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
            description: $request->input('description'),
        );
    }
}
