<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Group;
use Filament\Widgets\ChartWidget;

class GroupsStatsChart extends ChartWidget
{
    protected static ?string $heading = 'Активність груп';

    protected static ?int $sort = 8;

    protected static string $color = 'info';

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        // Топ-10 груп за кількістю учасників
        $topGroups = Group::query()
            ->withCount('members')
            ->orderByDesc('members_count')
            ->limit(10)
            ->get();

        $labels = $topGroups->pluck('name')->toArray();
        $data = $topGroups->pluck('members_count')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Кількість учасників',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.6)',
                        'rgba(34, 197, 94, 0.6)',
                        'rgba(251, 191, 36, 0.6)',
                        'rgba(239, 68, 68, 0.6)',
                        'rgba(168, 85, 247, 0.6)',
                        'rgba(236, 72, 153, 0.6)',
                        'rgba(20, 184, 166, 0.6)',
                        'rgba(249, 115, 22, 0.6)',
                        'rgba(139, 92, 246, 0.6)',
                        'rgba(14, 165, 233, 0.6)',
                    ],
                    'borderColor' => [
                        'rgb(59, 130, 246)',
                        'rgb(34, 197, 94)',
                        'rgb(251, 191, 36)',
                        'rgb(239, 68, 68)',
                        'rgb(168, 85, 247)',
                        'rgb(236, 72, 153)',
                        'rgb(20, 184, 166)',
                        'rgb(249, 115, 22)',
                        'rgb(139, 92, 246)',
                        'rgb(14, 165, 233)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}
