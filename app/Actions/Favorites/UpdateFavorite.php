<?php

namespace App\Actions\Favorites;

use App\Data\Favorite\FavoriteUpdateData;
use App\Models\Favorite;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateFavorite
{
    use AsAction;

    public function handle(Favorite $favorite, FavoriteUpdateData $data): Favorite
    {
        $favorite->update(array_filter([
            'user_id' => $data->user_id,
            'favoriteable_id' => $data->favoriteable_id,
            'favoriteable_type' => $data->favoriteable_type,
        ], fn ($value) => $value !== null));

        return $favorite->fresh(['user', 'favoriteable']);
    }
}
