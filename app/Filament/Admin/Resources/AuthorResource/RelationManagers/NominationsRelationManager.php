<?php

namespace App\Filament\Admin\Resources\AuthorResource\RelationManagers;

use App\Enums\NominationStatus;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class NominationsRelationManager extends RelationManager
{
    protected static string $relationship = 'nominations';

    protected static ?string $title = 'Номінації автора';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('award.name')
                    ->label('Нагорода')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('nomination.title')
                    ->label('Номінація')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('book.title')
                    ->label('За книгу')
                    ->searchable()
                    ->limit(40)
                    ->placeholder('За творчість')
                    ->toggleable(),
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
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Додано')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options(NominationStatus::class),
                Tables\Filters\SelectFilter::make('award_id')
                    ->label('Нагорода')
                    ->relationship('award', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Переглянути'),
            ])
            ->defaultSort('nomination.year', 'desc')
            ->emptyStateHeading('Немає номінацій')
            ->emptyStateDescription('Автор не має номінацій на нагороди.');
    }
}
