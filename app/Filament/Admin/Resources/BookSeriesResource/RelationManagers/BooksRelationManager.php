<?php

namespace App\Filament\Admin\Resources\BookSeriesResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class BooksRelationManager extends RelationManager
{
    protected static string $relationship = 'books';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $title = 'Книги серії';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Обкладинка')
                    ->size(50),
                Tables\Columns\TextColumn::make('number_in_series')
                    ->label('№')
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Назва')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('authors.name')
                    ->label('Автори')
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->searchable(),
                Tables\Columns\TextColumn::make('average_rating')
                    ->label('Рейтинг')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 1).' ⭐' : '—'),
                Tables\Columns\TextColumn::make('page_count')
                    ->label('Сторінок')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Переглянути'),
            ])
            ->defaultSort('number_in_series')
            ->reorderable('number_in_series')
            ->emptyStateHeading('Немає книг')
            ->emptyStateDescription('У цій серії ще немає книг.');
    }
}
