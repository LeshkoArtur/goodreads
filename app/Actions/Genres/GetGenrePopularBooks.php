<?php

namespace App\Actions\Genres;

use App\Data\Genre\GenreRelationIndexData;
use App\Models\Genre;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGenrePopularBooks
{
    use AsAction;

    public function handle(Genre $genre, GenreRelationIndexData $data): LengthAwarePaginator
    {
        $query = $genre->books()->orderBy('average_rating', 'desc')->where('average_rating', '>=', 4.0);

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
