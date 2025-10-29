<?php

namespace App\Filament\Admin\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class NewUsersChart extends ChartWidget
{
    protected static ?string $heading = 'Нові користувачі';

    protected static ?int $sort = 2;

    protected static string $color = 'info';

    public ?string $filter = '30';

    protected function getData(): array
    {
        $days = (int) $this->filter;

        $data = Trend::model(User::class)
            ->between(
                start: now()->subDays($days),
                end: now(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Нові користувачі',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'pointBackgroundColor' => 'rgb(59, 130, 246)',
                    'pointBorderColor' => '#fff',
                    'pointHoverBackgroundColor' => '#fff',
                    'pointHoverBorderColor' => 'rgb(59, 130, 246)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => date('d.m', strtotime($value->date))),
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
            '90' => '90 днів',
        ];
    }
}
