<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $title = 'Коментарі користувача';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('commentable_type')
                    ->label('Тип')
                    ->formatStateUsing(fn ($state) => class_basename($state))
                    ->badge()
                    ->color('info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('content')
                    ->label('Коментар')
                    ->searchable()
                    ->limit(100)
                    ->wrap(),
                Tables\Columns\IconColumn::make('parent_id')
                    ->label('Відповідь')
                    ->boolean()
                    ->exists('parent')
                    ->trueIcon('heroicon-o-chat-bubble-left-right')
                    ->falseIcon('heroicon-o-chat-bubble-left')
                    ->toggleable(),
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
                Tables\Filters\SelectFilter::make('commentable_type')
                    ->label('Тип')
                    ->options([
                        'App\\Models\\Post' => 'Пост',
                        'App\\Models\\Rating' => 'Оцінка',
                        'App\\Models\\Quote' => 'Цитата',
                        'App\\Models\\GroupPost' => 'Груповий пост',
                    ]),
                Tables\Filters\TernaryFilter::make('parent_id')
                    ->label('Тип коментаря')
                    ->placeholder('Всі')
                    ->trueLabel('Відповіді')
                    ->falseLabel('Коментарі')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('parent_id'),
                        false: fn ($query) => $query->whereNull('parent_id'),
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Переглянути'),
                Tables\Actions\DeleteAction::make()
                    ->label('Видалити')
                    ->requiresConfirmation()
                    ->modalDescription('Всі відповіді на цей коментар також будуть видалені.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Видалити обрані')
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Немає коментарів')
            ->emptyStateDescription('Користувач ще не залишив жодного коментаря.');
    }
}
