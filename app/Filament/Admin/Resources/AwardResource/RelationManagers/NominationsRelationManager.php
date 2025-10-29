<?php

namespace App\Filament\Admin\Resources\AwardResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class NominationsRelationManager extends RelationManager
{
    protected static string $relationship = 'nominations';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $title = 'Номінації';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Назва номінації')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('year')
                    ->label('Рік')
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('creator.username')
                    ->label('Створив')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('entries_count')
                    ->label('Номінантів')
                    ->counts('entries')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Переглянути'),
            ])
            ->defaultSort('year', 'desc')
            ->emptyStateHeading('Немає номінацій')
            ->emptyStateDescription('Для цієї нагороди ще не створено номінацій.');
    }
}
