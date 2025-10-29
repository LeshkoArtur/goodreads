<?php

namespace App\Filament\Admin\Resources\BookResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class QuotesRelationManager extends RelationManager
{
    protected static string $relationship = 'quotes';

    protected static ?string $title = 'Цитати';

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
                    ->color('info')
                    ->toggleable(),
                Tables\Columns\IconColumn::make('contains_spoilers')
                    ->label('Спойлер')
                    ->boolean()
                    ->trueIcon('heroicon-o-exclamation-triangle')
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueColor('danger')
                    ->falseColor('success')
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_public')
                    ->label('Публічна')
                    ->boolean()
                    ->toggleable(),
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
                    ->placeholder('Всі цитати')
                    ->trueLabel('Зі спойлерами')
                    ->falseLabel('Без спойлерів'),
                Tables\Filters\TernaryFilter::make('is_public')
                    ->label('Публічність')
                    ->placeholder('Всі цитати')
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
            ->emptyStateDescription('Поки що ніхто не додав цитати з цієї книги.');
    }
}
