<?php

namespace App\Actions\ReadingStats;

use App\Models\User;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetMonthlyStats
{
    use AsAction;

    public function handle(User $user, ?int $year = null): Collection
    {
        $targetYear = $year ?? now()->year;

        return $user->userBooks()
            ->whereYear('finish_date', $targetYear)
            ->whereNotNull('finish_date')
            ->selectRaw('MONTH(finish_date) as month, COUNT(*) as books_count, SUM(pages_read) as pages_count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(fn ($stat) => [
                'month' => $stat->month,
                'books_read' => $stat->books_count,
                'pages_read' => $stat->pages_count ?? 0,
            ]);
    }
}
