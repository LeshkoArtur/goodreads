<?php

namespace App\Actions\Favorites;

use App\DTOs\Favorite\FavoriteStoreDTO;
use App\Models\Favorite;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateFavorite
{
    use AsAction;

    /**
     * Створити новий запис улюбленого.
     *
     * @param FavoriteStoreDTO $dto
     * @return Favorite
     */
    public function handle(FavoriteStoreDTO $dto): Favorite
    {
        $favorite = new Favorite();
        $favorite->user_id = $dto->userId;
        $favorite->favoriteable_id = $dto->favoriteableId;
        $favorite->favoriteable_type = $dto->favoriteableType;

        $favorite->save();

        return $favorite->load(['user', 'favoriteable']);
    }
}
