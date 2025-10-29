<?php

namespace App\Filament\Admin\Resources\PostResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $title = 'Коментарі';

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
                    ->label('Автор')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('content')
                    ->label('Коментар')
                    ->searchable()
                    ->limit(120)
                    ->wrap(),
                Tables\Columns\IconColumn::make('parent_id')
                    ->label('Відповідь')
                    ->boolean()
                    ->exists('parent')
                    ->trueIcon('heroicon-o-chat-bubble-left-right')
                    ->falseIcon('heroicon-o-chat-bubble-left'),
                Tables\Columns\TextColumn::make('replies_count')
                    ->label('Відповідей')
                    ->counts('replies')
                    ->badge()
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('parent_id')
                    ->label('Тип')
                    ->placeholder('Всі')
                    ->trueLabel('Відповіді')
                    ->falseLabel('Коментарі')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('parent_id'),
                        false: fn ($query) => $query->whereNull('parent_id'),
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Переглянути'),
                Tables\Actions\DeleteAction::make()
                    ->label('Видалити')
                    ->requiresConfirmation()
                    ->modalDescription('Всі відповіді на цей коментар також будуть видалені.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Видалити обрані')->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Немає коментарів')
            ->emptyStateDescription('Поки що ніхто не прокоментував цей пост.');
    }
}
