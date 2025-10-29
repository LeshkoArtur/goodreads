<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AuthorsRelationManager extends RelationManager
{
    protected static string $relationship = 'authors';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Профілі авторів';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\ImageColumn::make('profile_picture')
                    ->label('Фото')
                    ->circular()
                    ->size(50)
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                Tables\Columns\TextColumn::make('name')
                    ->label('Ім\'я автора')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('nationality')
                    ->label('Національність')
                    ->badge()
                    ->color('info')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('type_of_work')
                    ->label('Тип творчості')
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('books_count')
                    ->label('Книг')
                    ->counts('books')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pivot.created_at')
                    ->label('Прив\'язано')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Прикріпити автора')
                    ->preloadRecordSelect()
                    ->modalHeading('Прикріпити профіль автора до користувача')
                    ->modalDescription('Користувач отримає можливість керувати цим профілем автора.'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Переглянути'),
                Tables\Actions\DetachAction::make()
                    ->label('Відкріпити')
                    ->requiresConfirmation()
                    ->modalHeading('Відкріпити профіль автора?')
                    ->modalDescription('Користувач втратить доступ до управління цим профілем автора.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->label('Відкріпити обрані')
                        ->requiresConfirmation(),
                ]),
            ])
            ->emptyStateHeading('Немає профілів авторів')
            ->emptyStateDescription('Користувач не має профілів авторів.')
            ->emptyStateActions([
                Tables\Actions\AttachAction::make()
                    ->label('Прикріпити автора')
                    ->preloadRecordSelect(),
            ]);
    }
}
