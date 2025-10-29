<?php

namespace App\Filament\Admin\Resources;

use App\Enums\Currency;
use App\Enums\OfferStatus;
use App\Filament\Admin\Resources\BookOfferResource\Pages;
use App\Models\BookOffer;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BookOfferResource extends Resource
{
    protected static ?string $model = BookOffer::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Електронна комерція';

    protected static ?int $navigationSort = 36;

    protected static ?string $recordTitleAttribute = 'id';

    public static function getModelLabel(): string
    {
        return 'Пропозиція книги';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Пропозиції книг';
    }

    public static function getNavigationLabel(): string
    {
        return 'Пропозиції книг';
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->book->title.' - '.$record->store->name;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['book', 'store']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Деталі пропозиції')
                    ->description('Інформація про комерційну пропозицію книги')
                    ->schema([
                        Select::make('book_id')
                            ->relationship('book', 'title')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Книга')
                            ->helperText('Книга, яка пропонується'),
                        Select::make('store_id')
                            ->relationship('store', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Магазин')
                            ->helperText('Магазин, що пропонує книгу'),
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('₴')
                            ->label('Ціна')
                            ->helperText('Ціна в обраній валюті'),
                        Select::make('currency')
                            ->options(Currency::class)
                            ->required()
                            ->native(false)
                            ->label('Валюта'),
                        TextInput::make('referral_url')
                            ->url()
                            ->maxLength(255)
                            ->label('Посилання на книгу')
                            ->helperText('Пряме посилання на книгу в магазині')
                            ->columnSpanFull(),
                        Toggle::make('availability')
                            ->required()
                            ->default(true)
                            ->label('В наявності')
                            ->helperText('Чи є книга в наявності зараз'),
                        Select::make('status')
                            ->options(OfferStatus::class)
                            ->required()
                            ->native(false)
                            ->label('Статус пропозиції')
                            ->helperText('Поточний статус активності'),
                        DateTimePicker::make('last_updated_at')
                            ->label('Останнє оновлення')
                            ->native(false),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('book.title')
                    ->label('Книга')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->tooltip(fn (BookOffer $record): ?string => $record->book->title),
                TextColumn::make('store.name')
                    ->label('Магазин')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('price')
                    ->label('Ціна')
                    ->money(fn ($record) => $record->currency->value)
                    ->sortable()
                    ->searchable(),
                IconColumn::make('availability')
                    ->label('Наявність')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('last_updated_at')
                    ->label('Оновлено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('book')
                    ->relationship('book', 'title')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->label('Книга'),
                SelectFilter::make('store')
                    ->relationship('store', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->label('Магазин'),
                SelectFilter::make('status')
                    ->options(OfferStatus::class)
                    ->native(false)
                    ->multiple()
                    ->label('Статус'),
                SelectFilter::make('currency')
                    ->options(Currency::class)
                    ->native(false)
                    ->multiple()
                    ->label('Валюта'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookOffers::route('/'),
            'create' => Pages\CreateBookOffer::route('/create'),
            'view' => Pages\ViewBookOffer::route('/{record}'),
            'edit' => Pages\EditBookOffer::route('/{record}/edit'),
        ];
    }
}
