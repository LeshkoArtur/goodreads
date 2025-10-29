<?php

namespace App\Actions\Shelves;

use App\Models\Shelf;
use Lorisleiva\Actions\Concerns\AsAction;

class GetShelfStats
{
    use AsAction;

    public function handle(Shelf $shelf): array
    {
        $books = $shelf->books;

        return [
            'total_books' => $books->count(),
            'average_rating' => round($books->avg('average_rating') ?? 0, 2),
            'total_pages' => $books->sum('page_count'),
            'read_books' => $shelf->userBooks()->whereNotNull('read_date')->count(),
            'currently_reading' => $shelf->userBooks()->whereNull('read_date')->whereNotNull('start_date')->count(),
            'total_authors' => $books->pluck('authors')->flatten()->unique('id')->count(),
        ];
    }
}
