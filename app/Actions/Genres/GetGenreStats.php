<?php

namespace App\Actions\Genres;

use App\Models\Genre;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGenreStats
{
    use AsAction;

    public function handle(Genre $genre): array
    {
        return [
            'total_books' => $genre->books()->count(),
            'total_subgenres' => $genre->subgenres()->count(),
            'average_rating' => round($genre->books()->avg('average_rating') ?? 0, 2),
            'total_pages' => $genre->books()->sum('page_count'),
            'recent_books' => $genre->books()->where('created_at', '>=', now()->subDays(30))->count(),
            'popular_books' => $genre->books()->where('average_rating', '>=', 4.5)->count(),
        ];
    }
}
