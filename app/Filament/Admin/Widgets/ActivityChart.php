<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Comment;
use App\Models\Rating;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ActivityChart extends ChartWidget
{
    protected static ?string $heading = 'Активність користувачів';

    protected static ?int $sort = 3;

    protected static string $color = 'success';

    public ?string $filter = '30';

    protected function getData(): array
    {
        $days = (int) $this->filter;

        $ratingsData = Trend::model(Rating::class)
            ->between(
                start: now()->subDays($days),
                end: now(),
            )
            ->perDay()
            ->count();

        $commentsData = Trend::model(Comment::class)
            ->between(
                start: now()->subDays($days),
                end: now(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Відгуки',
                    'data' => $ratingsData->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                    'borderColor' => 'rgb(34, 197, 94)',
                    'pointBackgroundColor' => 'rgb(34, 197, 94)',
                    'pointBorderColor' => '#fff',
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Коментарі',
                    'data' => $commentsData->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(251, 191, 36, 0.1)',
                    'borderColor' => 'rgb(251, 191, 36)',
                    'pointBackgroundColor' => 'rgb(251, 191, 36)',
                    'pointBorderColor' => '#fff',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $ratingsData->map(fn (TrendValue $value) => date('d.m', strtotime($value->date))),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            '7' => '7 днів',
            '14' => '14 днів',
            '30' => '30 днів',
            '60' => '60 днів',
        ];
    }
}
