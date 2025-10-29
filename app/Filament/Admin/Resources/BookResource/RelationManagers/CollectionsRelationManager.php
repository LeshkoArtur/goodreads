<?php

namespace App\Filament\Admin\Resources\BookResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CollectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'collections';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $title = 'Колекції';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Назва колекції')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('user.username')
                    ->label('Автор колекції')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_public')
                    ->label('Публічна')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('books_count')
                    ->label('Книг')
                    ->counts('books')
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('order_index')
                    ->label('Порядок')
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_public')
                    ->label('Публічність')
                    ->placeholder('Всі колекції')
                    ->trueLabel('Публічні')
                    ->falseLabel('Приватні'),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Додати до колекції')
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['title', 'description'])
                    ->modalHeading('Додати книгу до колекції'),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()
                    ->label('Видалити з колекції')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->label('Видалити з колекцій')
                        ->requiresConfirmation(),
                ]),
            ])
            ->emptyStateHeading('Немає колекцій')
            ->emptyStateDescription('Ця книга не входить в жодну колекцію.')
            ->emptyStateActions([
                Tables\Actions\AttachAction::make()
                    ->label('Додати до колекції')
                    ->preloadRecordSelect(),
            ]);
    }
}
