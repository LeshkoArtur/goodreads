<?php

namespace App\Actions\Favorites;

use App\Models\Favorite;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class GetFavoriteUser
{
    use AsAction;

    public function handle(Favorite $favorite): User
    {
        return $favorite->user;
    }
}
