<?php

namespace App\Actions\Collections;

use App\Models\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCollectionStats
{
    use AsAction;

    public function handle(Collection $collection): array
    {
        $books = $collection->books;

        return [
            'total_books' => $books->count(),
            'average_rating' => round($books->avg('average_rating') ?? 0, 2),
            'total_pages' => $books->sum('page_count'),
            'total_authors' => $books->pluck('authors')->flatten()->unique('id')->count(),
            'oldest_book' => $books->sortBy('publication_date')->first()?->only(['id', 'title', 'publication_date']),
            'newest_book' => $books->sortByDesc('publication_date')->first()?->only(['id', 'title', 'publication_date']),
            'highest_rated_book' => $books->sortByDesc('average_rating')->first()?->only(['id', 'title', 'average_rating']),
        ];
    }
}
