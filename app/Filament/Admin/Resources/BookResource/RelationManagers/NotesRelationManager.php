<?php

namespace App\Filament\Admin\Resources\BookResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class NotesRelationManager extends RelationManager
{
    protected static string $relationship = 'notes';

    protected static ?string $title = 'Нотатки';

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
                Tables\Columns\TextColumn::make('content')
                    ->label('Нотатка')
                    ->searchable()
                    ->limit(150)
                    ->wrap(),
                Tables\Columns\TextColumn::make('page_number')
                    ->label('Сторінка')
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_public')
                    ->label('Публічна')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_public')
                    ->label('Публічність')
                    ->placeholder('Всі нотатки')
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
            ->emptyStateHeading('Немає нотаток')
            ->emptyStateDescription('Поки що ніхто не залишив нотаток до цієї книги.');
    }
}
