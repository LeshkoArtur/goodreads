<?php

namespace App\Actions\BookSeries;

use App\Models\BookSeries;
use Lorisleiva\Actions\Concerns\AsAction;

class GetBookSeriesStats
{
    use AsAction;

    public function handle(BookSeries $bookSeries): array
    {
        return [
            'total_books' => $bookSeries->books()->count(),
            'average_rating' => round($bookSeries->books()->avg('average_rating') ?? 0, 2),
            'total_pages' => $bookSeries->books()->sum('page_count'),
            'is_completed' => $bookSeries->is_completed,
            'completed_percentage' => $bookSeries->total_books > 0
                ? round(($bookSeries->books()->count() / $bookSeries->total_books) * 100, 2)
                : 0,
            'highest_rated_book' => $bookSeries->books()->orderBy('average_rating', 'desc')->first()?->only(['id', 'title', 'average_rating']),
            'most_recent_book' => $bookSeries->books()->orderBy('created_at', 'desc')->first()?->only(['id', 'title', 'created_at']),
        ];
    }
}
