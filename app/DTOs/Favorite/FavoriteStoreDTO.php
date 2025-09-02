<?php

namespace App\DTOs\Favorite;

use Illuminate\Http\Request;

class FavoriteStoreDTO
{
    /**
     * @param string $userId ID користувача
     * @param string $favoriteableId ID об'єкта, що додається до обраного
     * @param string $favoriteableType Тип об'єкта, що додається до обраного
     */
    public function __construct(
        public readonly string $userId,
        public readonly string $favoriteableId,
        public readonly string $favoriteableType
    ) {}

    /**
     * Створити FavoriteStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            userId: $request->input('user_id'),
            favoriteableId: $request->input('favoriteable_id'),
            favoriteableType: $request->input('favoriteable_type')
        );
    }
}
