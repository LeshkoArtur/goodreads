<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Book;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopBooksWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = '📚 Топ-10 книг за рейтингом';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Book::query()
                    ->withCount('ratings')
                    ->whereHas('ratings')
                    ->orderByDesc('average_rating')
                    ->orderByDesc('ratings_count')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('rank')
                    ->label('#')
                    ->state(function ($rowLoop) {
                        return $rowLoop->iteration;
                    })
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        1 => 'warning',
                        2 => 'gray',
                        3 => 'danger',
                        default => 'primary',
                    })
                    ->icon(fn ($state) => match ($state) {
                        1 => 'heroicon-s-trophy',
                        2 => 'heroicon-s-trophy',
                        3 => 'heroicon-s-trophy',
                        default => null,
                    })
                    ->size(Tables\Columns\TextColumn\TextColumnSize::Large),
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Обкладинка')
                    ->disk('public')
                    ->size(60)
                    ->square(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Назва')
                    ->searchable()
                    ->weight('bold')
                    ->limit(40)
                    ->description(fn (Book $record) => $record->authors->pluck('name')->join(', '))
                    ->wrap(),
                Tables\Columns\TextColumn::make('average_rating')
                    ->label('Рейтинг')
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state >= 4.5 => 'success',
                        $state >= 4.0 => 'warning',
                        $state >= 3.5 => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => number_format($state, 2).' ⭐')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ratings_count')
                    ->label('Відгуків')
                    ->badge()
                    ->color('primary')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', ' '))
                    ->sortable(),
                Tables\Columns\TextColumn::make('page_count')
                    ->label('Сторінок')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Опубліковано')
                    ->date('Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Переглянути')
                    ->icon('heroicon-m-eye'),
            ])
            ->paginated(false);
    }
}
