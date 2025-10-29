<?php

namespace App\Actions\Authors;

use App\Data\Author\AuthorRelationIndexData;
use App\Models\Author;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetSimilarAuthors
{
    use AsAction;

    public function handle(Author $author, AuthorRelationIndexData $data): LengthAwarePaginator
    {
        $authorGenreIds = $author->books()
            ->with('genres')
            ->get()
            ->pluck('genres')
            ->flatten()
            ->pluck('id')
            ->unique()
            ->toArray();

        return Author::where('id', '!=', $author->id)
            ->when($author->nationality, fn ($query) => $query->where('nationality', $author->nationality))
            ->when($author->type_of_work, fn ($query) => $query->where('type_of_work', $author->type_of_work))
            ->whereHas('books.genres', function ($query) use ($authorGenreIds) {
                $query->whereIn('genres.id', $authorGenreIds);
            })
            ->withCount('books')
            ->with(['books' => function ($query) {
                $query->withAvg('ratings', 'value')->limit(3);
            }])
            ->orderByDesc('books_count')
            ->paginate(
                perPage: $data->per_page ?? 10,
                page: $data->page ?? 1
            );
    }
}
