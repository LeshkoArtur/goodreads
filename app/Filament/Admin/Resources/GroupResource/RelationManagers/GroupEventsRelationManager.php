<?php

namespace App\Filament\Admin\Resources\GroupResource\RelationManagers;

use App\Enums\EventStatus;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class GroupEventsRelationManager extends RelationManager
{
    protected static string $relationship = 'groupEvents';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $title = 'Події групи';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Назва події')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('creator.username')
                    ->label('Організатор')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event_date')
                    ->label('Дата події')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->color(fn ($state) => $state && $state->isPast() ? 'danger' : 'success'),
                Tables\Columns\TextColumn::make('location')
                    ->label('Місце')
                    ->limit(30)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (?EventStatus $state) => match ($state) {
                        EventStatus::UPCOMING => 'info',
                        EventStatus::ONGOING => 'warning',
                        EventStatus::COMPLETED => 'success',
                        EventStatus::CANCELLED => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('rsvps_count')
                    ->label('Відповідей')
                    ->counts('rsvps')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options(EventStatus::class),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Переглянути'),
                Tables\Actions\Action::make('cancel')
                    ->label('Скасувати')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status !== EventStatus::CANCELLED && $record->status !== EventStatus::COMPLETED)
                    ->action(fn ($record) => $record->update(['status' => EventStatus::CANCELLED])),
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
            ->defaultSort('event_date', 'desc')
            ->emptyStateHeading('Немає подій')
            ->emptyStateDescription('У цій групі ще немає запланованих подій.');
    }
}
