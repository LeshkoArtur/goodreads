<?php

namespace App\Actions\Publishers;

use App\Models\Publisher;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPublisherStats
{
    use AsAction;

    public function handle(Publisher $publisher): array
    {
        return [
            'total_books' => $publisher->books()->count(),
            'average_rating' => round($publisher->books()->avg('average_rating') ?? 0, 2),
            'total_pages' => $publisher->books()->sum('page_count'),
            'recent_books' => $publisher->books()->where('created_at', '>=', now()->subDays(30))->count(),
            'popular_books' => $publisher->books()->where('average_rating', '>=', 4.5)->count(),
            'total_authors' => $publisher->books()->with('authors')->get()->pluck('authors')->flatten()->unique('id')->count(),
        ];
    }
}
