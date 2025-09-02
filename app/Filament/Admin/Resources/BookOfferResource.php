<?php

namespace App\Filament\Admin\Resources;

use App\Enums\Currency;
use App\Enums\OfferStatus;
use App\Filament\Admin\Resources\BookOfferResource\Pages\CreateBookOffer;
use App\Filament\Admin\Resources\BookOfferResource\Pages\EditBookOffer;
use App\Filament\Admin\Resources\BookOfferResource\Pages\ListBookOffers;
use App\Filament\Admin\Resources\BookOfferResource\Pages\ViewBookOffer;
use App\Models\BookOffer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BookOfferResource extends Resource
{
    protected static ?string $model = BookOffer::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Магазини';

    protected static ?int $navigationSort = 9;

    public static function getNavigationLabel(): string
    {
        return __('Пропозиції книг');
    }

    public static function getModelLabel(): string
    {
        return __('Пропозиція книги');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Пропозиції книг');
    }

    public static function form(Form $form): Form
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
                        Select::make('store_id')
                            ->label(__('Магазин'))
                            ->relationship('store', 'name')
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

    public static function table(Table $table): Table
    {
        return $table
            ->query(BookOffer::query()->with(['book', 'store']))
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('book.title')
                    ->label(__('Книга'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record): ?string => $record->book ? route('filament.admin.resources.books.view', $record->book_id) : null),
                TextColumn::make('store.name')
                    ->label(__('Магазин'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record): ?string => $record->store ? route('filament.admin.resources.stores.view', $record->store_id) : null),
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
                SelectFilter::make('store')
                    ->label(__('Магазин'))
                    ->relationship('store', 'name')
                    ->searchable()
                    ->multiple()
                    ->indicator(__('Магазин')),
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
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label(__('Переглянути')),
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
            ->defaultSort('created_at', 'desc')
            ->groups([
                'book_id',
                'store_id',
                'currency',
                'status',
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookOffers::route('/'),
            'create' => CreateBookOffer::route('/create'),
            'view' => ViewBookOffer::route('/{record}'),
            'edit' => EditBookOffer::route('/{record}/edit'),
        ];
    }
}
