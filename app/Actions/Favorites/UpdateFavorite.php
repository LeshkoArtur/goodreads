<?php

namespace App\Actions\Favorites;

use App\DTOs\Favorite\FavoriteUpdateDTO;
use App\Models\Favorite;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateFavorite
{
    use AsAction;

    /**
     * Оновити існуючий запис улюбленого.
     *
     * @param Favorite $favorite
     * @param FavoriteUpdateDTO $dto
     * @return Favorite
     */
    public function handle(Favorite $favorite, FavoriteUpdateDTO $dto): Favorite
    {
        $attributes = [
            'favoriteable_type' => $dto->favoriteableType,
            'favoriteable_id' => $dto->favoriteableId,
        ];

        $favorite->fill(array_filter($attributes, fn($value) => $value !== null));

        $favorite->save();

        return $favorite->load(['user', 'favoriteable']);
    }
}
