<?php

namespace App\Actions\Favorites;

use App\Data\Favorite\FavoriteTypeData;
use App\Models\Book;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetFavoriteBooks
{
    use AsAction;

    public function handle(User $user, FavoriteTypeData $data): LengthAwarePaginator
    {
        return $user->favorites()
            ->where('favoriteable_type', Book::class)
            ->with(['favoriteable'])
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
