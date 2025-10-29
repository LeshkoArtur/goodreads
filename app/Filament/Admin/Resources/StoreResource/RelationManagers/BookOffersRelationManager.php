<?php

namespace App\Filament\Admin\Resources\StoreResource\RelationManagers;

use App\Enums\OfferStatus;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class BookOffersRelationManager extends RelationManager
{
    protected static string $relationship = 'bookOffers';

    protected static ?string $title = 'Пропозиції книг';

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
                    ->sortable()
                    ->limit(40)
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Ціна')
                    ->money('UAH')
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_price')
                    ->label('Ціна зі знижкою')
                    ->money('UAH')
                    ->sortable()
                    ->placeholder('—')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (?OfferStatus $state) => match ($state) {
                        OfferStatus::ACTIVE => 'success',
                        OfferStatus::INACTIVE => 'gray',
                        OfferStatus::EXPIRED => 'danger',
                        OfferStatus::OUT_OF_STOCK => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('url')
                    ->label('Посилання')
                    ->url(fn ($record) => $record->url)
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->limit(30)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Додано')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options(OfferStatus::class),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Переглянути'),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Немає пропозицій')
            ->emptyStateDescription('У цьому магазині ще немає пропозицій книг.');
    }
}
