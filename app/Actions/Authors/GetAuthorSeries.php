<?php

namespace App\Actions\Authors;

use App\Data\Author\AuthorRelationIndexData;
use App\Models\Author;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAuthorSeries
{
    use AsAction;

    public function handle(Author $author, AuthorRelationIndexData $data): LengthAwarePaginator
    {
        $series = $author->books()
            ->whereNotNull('series_id')
            ->with('series')
            ->get()
            ->pluck('series')
            ->unique('id')
            ->values();

        return new LengthAwarePaginator(
            $series->forPage($data->page ?? 1, $data->per_page ?? 15),
            $series->count(),
            $data->per_page ?? 15,
            $data->page ?? 1
        );
    }
}
