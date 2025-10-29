<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class BooksRelationManager extends RelationManager
{
    protected static string $relationship = 'books';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $title = 'Книги користувача';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\ImageColumn::make('book.cover_image')
                    ->label('Обкладинка')
                    ->size(50),
                Tables\Columns\TextColumn::make('book.title')
                    ->label('Назва книги')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('book.authors.name')
                    ->label('Автори')
                    ->searchable()
                    ->limit(30)
                    ->listWithLineBreaks()
                    ->limitList(2),
                Tables\Columns\TextColumn::make('reading_status')
                    ->label('Статус читання')
                    ->badge()
                    ->color(fn ($state) => match ($state?->value) {
                        'reading' => 'warning',
                        'completed' => 'success',
                        'to_read' => 'info',
                        'abandoned' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('progress')
                    ->label('Прогрес')
                    ->suffix('%')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('started_at')
                    ->label('Почав читати')
                    ->date('d.m.Y')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('finished_at')
                    ->label('Закінчив читати')
                    ->date('d.m.Y')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Додано')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('reading_status')
                    ->label('Статус читання')
                    ->options([
                        'to_read' => 'Хочу прочитати',
                        'reading' => 'Читаю',
                        'completed' => 'Прочитано',
                        'abandoned' => 'Покинуто',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Переглянути'),
                Tables\Actions\DeleteAction::make()
                    ->label('Видалити')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Видалити обрані')
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Немає книг')
            ->emptyStateDescription('Користувач ще не додав жодної книги.');
    }
}
