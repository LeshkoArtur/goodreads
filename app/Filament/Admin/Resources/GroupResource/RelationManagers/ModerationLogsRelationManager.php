<?php

namespace App\Filament\Admin\Resources\GroupResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ModerationLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'groupModerationLogs';

    protected static ?string $title = 'Логи модерації';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('moderator.profile_picture')
                    ->label('Модератор')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                Tables\Columns\TextColumn::make('moderator.username')
                    ->label('Модератор')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\ImageColumn::make('subject.profile_picture')
                    ->label('Об\'єкт дії')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                Tables\Columns\TextColumn::make('subject.username')
                    ->label('Користувач')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('action')
                    ->label('Дія')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'ban', 'remove_post', 'kick' => 'danger',
                        'unban', 'approve_post' => 'success',
                        'pin_post', 'promote' => 'warning',
                        default => 'info',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('reason')
                    ->label('Причина')
                    ->limit(80)
                    ->wrap()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('action')
                    ->label('Дія')
                    ->options([
                        'ban' => 'Бан',
                        'unban' => 'Розбан',
                        'kick' => 'Виключення',
                        'remove_post' => 'Видалення посту',
                        'pin_post' => 'Закріплення посту',
                        'approve_post' => 'Схвалення посту',
                        'promote' => 'Підвищення',
                        'demote' => 'Пониження',
                    ]),
                Tables\Filters\SelectFilter::make('moderator_id')
                    ->label('Модератор')
                    ->relationship('moderator', 'username')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Деталі'),
            ])
            ->bulkActions([
                // Логи модерації не видаляються
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Немає логів')
            ->emptyStateDescription('У цій групі ще не було дій модерації.');
    }
}
