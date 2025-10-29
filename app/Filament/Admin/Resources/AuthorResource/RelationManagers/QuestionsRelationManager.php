<?php

namespace App\Filament\Admin\Resources\AuthorResource\RelationManagers;

use App\Enums\QuestionStatus;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    protected static ?string $title = 'Питання до автора';

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
                    ->label('Від кого')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('content')
                    ->label('Питання')
                    ->searchable()
                    ->limit(100)
                    ->wrap(),
                Tables\Columns\TextColumn::make('book.title')
                    ->label('Книга')
                    ->searchable()
                    ->limit(30)
                    ->placeholder('Загальне питання')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (?QuestionStatus $state) => match ($state) {
                        QuestionStatus::PENDING => 'warning',
                        QuestionStatus::ANSWERED => 'success',
                        QuestionStatus::DECLINED => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('answers_count')
                    ->label('Відповідей')
                    ->counts('answers')
                    ->badge()
                    ->color('success')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options(QuestionStatus::class),
                Tables\Filters\TernaryFilter::make('book_id')
                    ->label('Тип питання')
                    ->placeholder('Всі')
                    ->trueLabel('Про конкретну книгу')
                    ->falseLabel('Загальні')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('book_id'),
                        false: fn ($query) => $query->whereNull('book_id'),
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
            ->emptyStateHeading('Немає питань')
            ->emptyStateDescription('Поки що ніхто не задав питання цьому автору.');
    }
}
