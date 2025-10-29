<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class QuotesRelationManager extends RelationManager
{
    protected static string $relationship = 'quotes';

    protected static ?string $title = 'Цитати користувача';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('book.title')
                    ->label('Книга')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('text')
                    ->label('Цитата')
                    ->searchable()
                    ->limit(150)
                    ->wrap()
                    ->weight('medium'),
                Tables\Columns\TextColumn::make('page_number')
                    ->label('Сторінка')
                    ->sortable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\IconColumn::make('contains_spoilers')
                    ->label('Спойлер')
                    ->boolean()
                    ->trueColor('danger')
                    ->falseColor('success'),
                Tables\Columns\IconColumn::make('is_public')
                    ->label('Публічна')
                    ->boolean(),
                Tables\Columns\TextColumn::make('likes_count')
                    ->label('Лайки')
                    ->counts('likes')
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('contains_spoilers')
                    ->label('Спойлери')
                    ->placeholder('Всі')
                    ->trueLabel('Зі спойлерами')
                    ->falseLabel('Без спойлерів'),
                Tables\Filters\TernaryFilter::make('is_public')
                    ->label('Публічність')
                    ->placeholder('Всі')
                    ->trueLabel('Публічні')
                    ->falseLabel('Приватні'),
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
            ->emptyStateHeading('Немає цитат')
            ->emptyStateDescription('Користувач ще не додав жодної цитати.');
    }
}
