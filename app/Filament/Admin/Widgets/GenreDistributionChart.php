<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class GenreDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Розподіл книг за жанрами';

    protected static ?int $sort = 5;

    protected static string $color = 'warning';

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $topGenres = DB::table('book_genre')
            ->join('genres', 'book_genre.genre_id', '=', 'genres.id')
            ->select('genres.name', DB::raw('count(*) as books_count'))
            ->groupBy('genres.id', 'genres.name')
            ->orderByDesc('books_count')
            ->limit(10)
            ->get();

        $labels = $topGenres->pluck('name')->toArray();
        $data = $topGenres->pluck('books_count')->toArray();

        $colors = [
            'rgba(59, 130, 246, 0.8)',   // blue
            'rgba(34, 197, 94, 0.8)',    // green
            'rgba(251, 191, 36, 0.8)',   // yellow
            'rgba(239, 68, 68, 0.8)',    // red
            'rgba(168, 85, 247, 0.8)',   // purple
            'rgba(236, 72, 153, 0.8)',   // pink
            'rgba(20, 184, 166, 0.8)',   // teal
            'rgba(249, 115, 22, 0.8)',   // orange
            'rgba(139, 92, 246, 0.8)',   // violet
            'rgba(14, 165, 233, 0.8)',   // sky
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Кількість книг',
                    'data' => $data,
                    'backgroundColor' => array_slice($colors, 0, count($data)),
                    'borderColor' => '#fff',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
            'maintainAspectRatio' => true,
        ];
    }
}
