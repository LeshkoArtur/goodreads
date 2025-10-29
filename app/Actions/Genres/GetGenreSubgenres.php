<?php

namespace App\Actions\Genres;

use App\Data\Genre\GenreRelationIndexData;
use App\Models\Genre;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGenreSubgenres
{
    use AsAction;

    public function handle(Genre $genre, GenreRelationIndexData $data): LengthAwarePaginator
    {
        $query = $genre->subgenres();

        if ($data->sort && in_array($data->sort, ['name', 'created_at', 'book_count'])) {
            $query->orderBy($data->sort, $data->direction ?? 'desc');
        }

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
