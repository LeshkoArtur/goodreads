<?php

namespace App\Actions\Genres;

use App\Data\Genre\GenreRelationIndexData;
use App\Models\Genre;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGenreTrendingBooks
{
    use AsAction;

    public function handle(Genre $genre, GenreRelationIndexData $data): LengthAwarePaginator
    {
        $query = $genre->books()
            ->where('created_at', '>=', now()->subDays(30))
            ->orderBy('average_rating', 'desc');

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
