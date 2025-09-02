<?php

namespace App\DTOs\Favorite;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних улюбленого.
 */
class FavoriteUpdateDTO
{
    /**
     * Створює новий екземпляр FavoriteUpdateDTO.
     *
     * @param string|null $favoriteableType Тип улюбленого об’єкта
     * @param string|null $favoriteableId ID улюбленого об’єкта
     */
    public function __construct(
        public readonly ?string $favoriteableType = null,
        public readonly ?string $favoriteableId = null,
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
            favoriteableType: $request->input('favoriteable_type'),
            favoriteableId: $request->input('favoriteable_id'),
        );
    }
}
