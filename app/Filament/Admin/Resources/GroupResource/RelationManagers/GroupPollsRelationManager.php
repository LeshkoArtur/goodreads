<?php

namespace App\Filament\Admin\Resources\GroupResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class GroupPollsRelationManager extends RelationManager
{
    protected static string $relationship = 'groupPolls';

    protected static ?string $recordTitleAttribute = 'question';

    protected static ?string $title = 'Опитування';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question')
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->label('Питання')
                    ->searchable()
                    ->limit(80)
                    ->weight('bold')
                    ->wrap(),
                Tables\Columns\TextColumn::make('creator.username')
                    ->label('Створив')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('options_count')
                    ->label('Варіантів')
                    ->counts('pollOptions')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('votes_count')
                    ->label('Голосів')
                    ->counts('pollVotes')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                Tables\Columns\IconColumn::make('allows_multiple_votes')
                    ->label('Багато варіантів')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('closes_at')
                    ->label('Закінчується')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->color(fn ($state) => $state && $state->isPast() ? 'danger' : 'success')
                    ->placeholder('Не обмежено'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('closes_at')
                    ->label('Статус')
                    ->placeholder('Всі')
                    ->trueLabel('Активні')
                    ->falseLabel('Завершені')
                    ->queries(
                        true: fn ($query) => $query->where('closes_at', '>', now())->orWhereNull('closes_at'),
                        false: fn ($query) => $query->where('closes_at', '<=', now()),
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Переглянути'),
                Tables\Actions\Action::make('close')
                    ->label('Закрити')
                    ->icon('heroicon-o-lock-closed')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => ! $record->closes_at || $record->closes_at->isFuture())
                    ->action(fn ($record) => $record->update(['closes_at' => now()])),
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
            ->emptyStateHeading('Немає опитувань')
            ->emptyStateDescription('У цій групі ще не було створено опитувань.');
    }
}
