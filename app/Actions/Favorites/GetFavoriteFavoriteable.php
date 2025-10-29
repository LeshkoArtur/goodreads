<?php

namespace App\Actions\Favorites;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Model;
use Lorisleiva\Actions\Concerns\AsAction;

class GetFavoriteFavoriteable
{
    use AsAction;

    public function handle(Favorite $favorite): ?Model
    {
        return $favorite->favoriteable;
    }
}
