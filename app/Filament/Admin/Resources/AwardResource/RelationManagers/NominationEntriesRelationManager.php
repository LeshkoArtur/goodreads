<?php

namespace App\Filament\Admin\Resources\AwardResource\RelationManagers;

use App\Enums\NominationStatus;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class NominationEntriesRelationManager extends RelationManager
{
    protected static string $relationship = 'nominationEntries';

    protected static ?string $title = 'Всі номінанти нагороди';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomination.title')
                    ->label('Номінація')
                    ->searchable()
                    ->sortable(),
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
                Tables\Columns\TextColumn::make('nomination.year')
                    ->label('Рік')
                    ->sortable()
                    ->badge(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options(NominationStatus::class),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Переглянути'),
            ])
            ->defaultSort('nomination.year', 'desc')
            ->emptyStateHeading('Немає номінантів')
            ->emptyStateDescription('Для цієї нагороди ще немає номінантів.');
    }
}
