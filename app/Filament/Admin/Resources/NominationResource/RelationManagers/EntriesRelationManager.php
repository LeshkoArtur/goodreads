<?php

namespace App\Filament\Admin\Resources\NominationResource\RelationManagers;

use App\Enums\NominationStatus;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class EntriesRelationManager extends RelationManager
{
    protected static string $relationship = 'entries';

    protected static ?string $title = 'Номінанти';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('book.cover_image')
                    ->label('Обкладинка')
                    ->size(50),
                Tables\Columns\TextColumn::make('book.title')
                    ->label('Книга')
                    ->searchable()
                    ->limit(40)
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Автор')
                    ->searchable()
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (?NominationStatus $state) => match ($state) {
                        NominationStatus::PENDING => 'warning',
                        NominationStatus::NOMINATED => 'info',
                        NominationStatus::WINNER => 'success',
                        NominationStatus::REJECTED => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Додано')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options(NominationStatus::class),
            ])
            ->actions([
                Tables\Actions\Action::make('markAsWinner')
                    ->label('Переможець')
                    ->icon('heroicon-o-trophy')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status !== NominationStatus::WINNER)
                    ->action(fn ($record) => $record->update(['status' => NominationStatus::WINNER])),
                Tables\Actions\ViewAction::make()->label('Переглянути'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve')
                        ->label('Схвалити')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update(['status' => NominationStatus::NOMINATED])),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Немає номінантів')
            ->emptyStateDescription('До цієї номінації ще не додано номінантів.');
    }
}
