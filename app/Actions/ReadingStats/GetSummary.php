<?php

namespace App\Actions\ReadingStats;

use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class GetSummary
{
    use AsAction;

    public function handle(User $user): array
    {
        $totalStats = $user->readingStats()
            ->selectRaw('SUM(books_read) as total_books, SUM(pages_read) as total_pages')
            ->first();

        $currentYearStat = $user->readingStats()
            ->where('year', now()->year)
            ->first();

        return [
            'total_books_read' => $totalStats->total_books ?? 0,
            'total_pages_read' => $totalStats->total_pages ?? 0,
            'current_year_books' => $currentYearStat?->books_read ?? 0,
            'current_year_pages' => $currentYearStat?->pages_read ?? 0,
            'current_year_genres' => $currentYearStat?->genres_read ?? [],
            'years_active' => $user->readingStats()->distinct('year')->count('year'),
        ];
    }
}
