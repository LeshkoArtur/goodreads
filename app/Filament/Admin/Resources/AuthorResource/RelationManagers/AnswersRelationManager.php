<?php

namespace App\Filament\Admin\Resources\AuthorResource\RelationManagers;

use App\Enums\AnswerStatus;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AnswersRelationManager extends RelationManager
{
    protected static string $relationship = 'answers';

    protected static ?string $title = 'Відповіді автора';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question.content')
                    ->label('Питання')
                    ->searchable()
                    ->limit(80)
                    ->wrap()
                    ->tooltip(fn ($record) => $record->question?->content),
                Tables\Columns\TextColumn::make('question.user.username')
                    ->label('Питав')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('content')
                    ->label('Відповідь')
                    ->searchable()
                    ->limit(100)
                    ->wrap(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (?AnswerStatus $state) => match ($state) {
                        AnswerStatus::PENDING => 'warning',
                        AnswerStatus::APPROVED => 'success',
                        AnswerStatus::REJECTED => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options(AnswerStatus::class),
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
            ->emptyStateHeading('Немає відповідей')
            ->emptyStateDescription('Автор ще не відповів на жодне питання.');
    }
}
