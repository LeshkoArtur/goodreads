<?php

namespace App\Filament\Admin\Resources\ShelfResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class BooksRelationManager extends RelationManager
{
    protected static string $relationship = 'books';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $title = 'Книги на полиці';

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
                Tables\Columns\TextColumn::make('pivot.rating')
                    ->label('Оцінка користувача')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state >= 4 => 'success',
                        $state >= 3 => 'warning',
                        $state >= 1 => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => $state ? $state.' ⭐' : '—'),
                Tables\Columns\TextColumn::make('pivot.progress_pages')
                    ->label('Прогрес')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('pivot.start_date')
                    ->label('Початок читання')
                    ->date('d.m.Y')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('pivot.read_date')
                    ->label('Прочитано')
                    ->date('d.m.Y')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('pivot.created_at')
                    ->label('Додано на полицю')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Додати книгу')
                    ->preloadRecordSelect()
                    ->multiple()
                    ->modalHeading('Додати книги на полицю'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Переглянути'),
                Tables\Actions\DetachAction::make()->label('Видалити')->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()->label('Видалити обрані')->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('pivot.created_at', 'desc')
            ->emptyStateHeading('Немає книг')
            ->emptyStateDescription('На цій полиці ще немає книг.')
            ->emptyStateActions([
                Tables\Actions\AttachAction::make()->label('Додати книгу')->preloadRecordSelect()->multiple(),
            ]);
    }
}
