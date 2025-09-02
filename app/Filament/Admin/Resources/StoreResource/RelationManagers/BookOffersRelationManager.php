<?php

namespace App\Filament\Admin\Resources\StoreResource\RelationManagers;

use App\Enums\Currency;
use App\Enums\OfferStatus;
use App\Models\Store;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BookOffersRelationManager extends RelationManager
{
    protected static string $relationship = 'bookOffers';

    protected static ?string $recordTitleAttribute = 'book_id';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Пропозиції книг у магазині') . ' ' . $ownerRecord->name;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make(__('Пропозиція книги'))
                    ->schema([
                        Select::make('book_id')
                            ->label(__('Книга'))
                            ->relationship('book', 'title')
                            ->required()
                            ->searchable()
                            ->preload(),
                        TextInput::make('price')
                            ->label(__('Ціна'))
                            ->numeric()
                            ->minValue(0)
                            ->required(),
                        Select::make('currency')
                            ->label(__('Валюта'))
                            ->options(Currency::class)
                            ->required(),
                        TextInput::make('referral_url')
                            ->label(__('Реферальне посилання'))
                            ->url()
                            ->maxLength(255)
                            ->nullable(),
                        Toggle::make('availability')
                            ->label(__('В наявності'))
                            ->default(true),
                        Select::make('status')
                            ->label(__('Статус'))
                            ->options(OfferStatus::class)
                            ->required(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('book.title')
                    ->label(__('Книга'))
                    ->searchable()
                    ->sortable()
                    ->url(fn (Model $record): ?string => $record->book ? route('filament.admin.resources.books.view', $record->book_id) : null),
                TextColumn::make('price')
                    ->label(__('Ціна'))
                    ->money(fn ($record) => $record->currency?->value)
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('currency')
                    ->label(__('Валюта'))
                    ->badge()
                    ->formatStateUsing(fn (?Currency $state) => $state?->getLabel())
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('referral_url')
                    ->label(__('Реферальне посилання'))
                    ->url(fn ($record) => $record->referral_url)
                    ->openUrlInNewTab()
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('availability')
                    ->label(__('В наявності'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->label(__('Статус'))
                    ->badge()
                    ->formatStateUsing(fn (?OfferStatus $state) => $state?->getLabel())
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('last_updated_at')
                    ->label(__('Останнє оновлення'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(__('Дата створення'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label(__('Дата оновлення'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('book')
                    ->label(__('Книга'))
                    ->relationship('book', 'title')
                    ->searchable()
                    ->multiple()
                    ->indicator(__('Книга')),
                SelectFilter::make('currency')
                    ->label(__('Валюта'))
                    ->options(Currency::class)
                    ->multiple()
                    ->indicator(__('Валюта')),
                TernaryFilter::make('availability')
                    ->label(__('В наявності'))
                    ->placeholder(__('Всі'))
                    ->trueLabel(__('В наявності'))
                    ->falseLabel(__('Немає в наявності'))
                    ->indicator(__('В наявності')),
                SelectFilter::make('status')
                    ->label(__('Статус'))
                    ->options(OfferStatus::class)
                    ->multiple()
                    ->indicator(__('Статус')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('Додати пропозицію книги')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(__('Редагувати')),
                Tables\Actions\DeleteAction::make()
                    ->label(__('Видалити')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label(__('Видалити вибрані')),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
