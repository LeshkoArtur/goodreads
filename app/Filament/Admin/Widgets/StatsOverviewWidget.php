<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Author;
use App\Models\Book;
use App\Models\Group;
use App\Models\Rating;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $usersCount = User::count();
        $usersThisMonth = User::whereMonth('created_at', now()->month)->count();
        $usersLastMonth = User::whereMonth('created_at', now()->subMonth()->month)->count();
        $usersTrend = $usersLastMonth > 0
            ? round((($usersThisMonth - $usersLastMonth) / $usersLastMonth) * 100, 1)
            : 0;

        $booksCount = Book::count();
        $booksThisMonth = Book::whereMonth('created_at', now()->month)->count();

        $authorsCount = Author::count();
        $authorsThisMonth = Author::whereMonth('created_at', now()->month)->count();

        $ratingsCount = Rating::count();
        $ratingsThisMonth = Rating::whereMonth('created_at', now()->month)->count();
        $ratingsLastMonth = Rating::whereMonth('created_at', now()->subMonth()->month)->count();
        $ratingsTrend = $ratingsLastMonth > 0
            ? round((($ratingsThisMonth - $ratingsLastMonth) / $ratingsLastMonth) * 100, 1)
            : 0;

        $avgRating = Rating::avg('rating');

        $groupsCount = Group::count();
        $activeGroups = Group::whereHas('members', function ($query) {
            $query->where('status', 'active');
        })->count();

        return [
            Stat::make('Користувачі', number_format($usersCount, 0, ',', ' '))
                ->description($usersThisMonth.' нових цього місяця')
                ->descriptionIcon($usersTrend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($usersTrend >= 0 ? 'success' : 'danger')
                ->chart(array_values($this->getUsersChartData()))
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition',
                ]),

            Stat::make('Книги', number_format($booksCount, 0, ',', ' '))
                ->description($booksThisMonth.' додано цього місяця')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('primary')
                ->chart(array_values($this->getBooksChartData()))
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition',
                ]),

            Stat::make('Автори', number_format($authorsCount, 0, ',', ' '))
                ->description($authorsThisMonth.' нових цього місяця')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info')
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition',
                ]),

            Stat::make('Відгуки', number_format($ratingsCount, 0, ',', ' '))
                ->description($ratingsThisMonth.' нових цього місяця ('.($ratingsTrend >= 0 ? '+' : '').$ratingsTrend.'%)')
                ->descriptionIcon($ratingsTrend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($ratingsTrend >= 0 ? 'success' : 'warning')
                ->chart(array_values($this->getRatingsChartData()))
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition',
                ]),

            Stat::make('Середній рейтинг', number_format($avgRating, 2).' ⭐')
                ->description('З '.number_format($ratingsCount, 0, ',', ' ').' оцінок')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning')
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition',
                ]),

            Stat::make('Групи', number_format($groupsCount, 0, ',', ' '))
                ->description($activeGroups.' активних')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success')
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition',
                ]),
        ];
    }

    private function getUsersChartData(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $data[$date->format('d.m')] = User::whereDate('created_at', $date)->count();
        }

        return $data;
    }

    private function getBooksChartData(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $data[$date->format('d.m')] = Book::whereDate('created_at', $date)->count();
        }

        return $data;
    }

    private function getRatingsChartData(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $data[$date->format('d.m')] = Rating::whereDate('created_at', $date)->count();
        }

        return $data;
    }
}
