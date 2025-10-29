<?php

namespace App\Filament\Admin\Resources\BookResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class RatingsRelationManager extends RelationManager
{
    protected static string $relationship = 'ratings';

    protected static ?string $title = 'Оцінки';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('user.profile_picture')
                    ->label('Користувач')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                Tables\Columns\TextColumn::make('user.username')
                    ->label('Ім\'я користувача')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Оцінка')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state >= 4 => 'success',
                        $state >= 3 => 'warning',
                        default => 'danger',
                    })
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', $state)),
                Tables\Columns\TextColumn::make('review')
                    ->label('Відгук')
                    ->limit(100)
                    ->searchable()
                    ->wrap()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('comments_count')
                    ->label('Коментарі')
                    ->counts('comments')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('likes_count')
                    ->label('Лайки')
                    ->counts('likes')
                    ->badge()
                    ->color('success')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('rating')
                    ->label('Оцінка')
                    ->options([
                        1 => '1⭐',
                        2 => '2⭐⭐',
                        3 => '3⭐⭐⭐',
                        4 => '4⭐⭐⭐⭐',
                        5 => '5⭐⭐⭐⭐⭐',
                    ]),
                Tables\Filters\TernaryFilter::make('review')
                    ->label('З відгуком')
                    ->placeholder('Всі оцінки')
                    ->trueLabel('Тільки з відгуком')
                    ->falseLabel('Без відгуку')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('review'),
                        false: fn ($query) => $query->whereNull('review'),
                    ),
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
            ->emptyStateHeading('Немає оцінок')
            ->emptyStateDescription('Поки що ніхто не оцінив цю книгу.');
    }
}
