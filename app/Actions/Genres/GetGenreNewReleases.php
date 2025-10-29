<?php

namespace App\Actions\Genres;

use App\Data\Genre\GenreRelationIndexData;
use App\Models\Genre;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGenreNewReleases
{
    use AsAction;

    public function handle(Genre $genre, GenreRelationIndexData $data): LengthAwarePaginator
    {
        $query = $genre->books()->orderBy('created_at', 'desc');

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
