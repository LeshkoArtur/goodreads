<?php

namespace App\Actions\Favorites;

use App\Data\Favorite\FavoriteStoreData;
use App\Models\Favorite;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateFavorite
{
    use AsAction;

    public function handle(FavoriteStoreData $data, User $user): Favorite
    {
        $favorite = new Favorite;
        $favorite->user_id = $user->id;
        $favorite->favoriteable_type = $data->favoriteable_type;
        $favorite->favoriteable_id = $data->favoriteable_id;
        $favorite->save();

        return $favorite->fresh(['user', 'favoriteable']);
    }
}
