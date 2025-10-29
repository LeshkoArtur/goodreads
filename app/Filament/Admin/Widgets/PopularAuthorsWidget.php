<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Author;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PopularAuthorsWidget extends BaseWidget
{
    protected static ?int $sort = 7;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = '✍️ Топ-10 авторів';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Author::query()
                    ->withCount('books')
                    ->orderByDesc('books_count')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('rank')
                    ->label('#')
                    ->state(function ($rowLoop) {
                        return $rowLoop->iteration;
                    })
                    ->badge()
                    ->color('primary'),
                Tables\Columns\ImageColumn::make('profile_picture')
                    ->label('Фото')
                    ->disk('public')
                    ->size(50)
                    ->circular()
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name='.urlencode($record->name)),
                Tables\Columns\TextColumn::make('name')
                    ->label('Ім\'я')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn (Author $record) => $record->nationality ?: '—')
                    ->wrap(),
                Tables\Columns\TextColumn::make('books_count')
                    ->label('Книг')
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', ' '))
                    ->sortable(),
                Tables\Columns\TextColumn::make('type_of_work')
                    ->label('Тип творчості')
                    ->badge()
                    ->color('info')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->label('Дата народження')
                    ->date('d.m.Y')
                    ->toggleable()
                    ->placeholder('—'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Переглянути')
                    ->icon('heroicon-m-eye'),
            ])
            ->paginated(false);
    }
}
