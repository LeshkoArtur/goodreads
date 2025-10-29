<?php

namespace App\Filament\Admin\Resources\GenreResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class BooksRelationManager extends RelationManager
{
    protected static string $relationship = 'books';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $title = 'Книги жанру';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Обкладинка')
                    ->size(50),
                Tables\Columns\TextColumn::make('title')
                    ->label('Назва')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('authors.name')
                    ->label('Автори')
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->searchable(),
                Tables\Columns\TextColumn::make('average_rating')
                    ->label('Рейтинг')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state >= 4.5 => 'success',
                        $state >= 3.5 => 'warning',
                        default => 'info',
                    })
                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 1).' ⭐' : '—'),
                Tables\Columns\IconColumn::make('is_bestseller')
                    ->label('Бестселер')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Додано')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_bestseller')
                    ->label('Бестселер'),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Додати книгу')
                    ->preloadRecordSelect()
                    ->multiple()
                    ->modalHeading('Додати книги до жанру'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Переглянути'),
                Tables\Actions\DetachAction::make()->label('Відкріпити')->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()->label('Відкріпити обрані')->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Немає книг')
            ->emptyStateDescription('До цього жанру ще не додано книг.')
            ->emptyStateActions([
                Tables\Actions\AttachAction::make()->label('Додати книгу')->preloadRecordSelect()->multiple(),
            ]);
    }
}
