<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\StoreResource\Pages\CreateStore;
use App\Filament\Admin\Resources\StoreResource\Pages\EditStore;
use App\Filament\Admin\Resources\StoreResource\Pages\ListStores;
use App\Filament\Admin\Resources\StoreResource\Pages\ViewStore;
use App\Filament\Admin\Resources\StoreResource\RelationManagers\BookOffersRelationManager;
use App\Models\Store;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StoreResource extends Resource
{
    protected static ?string $model = Store::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Магазини';

    protected static ?int $navigationSort = 8;

    public static function getNavigationLabel(): string
    {
        return __('Магазини');
    }

    public static function getModelLabel(): string
    {
        return __('Магазин');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Магазини');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Інформація про магазин'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Назва'))
                            ->required()
                            ->maxLength(255)
                            ->unique(Store::class, 'name', ignoreRecord: true),
                        Forms\Components\FileUpload::make('logo_url')
                            ->label(__('Логотип'))
                            ->directory('store_logos')
                            ->image()
                            ->maxSize(2048)
                            ->nullable(),
                        TextInput::make('region')
                            ->label(__('Регіон'))
                            ->maxLength(255)
                            ->nullable(),
                        TextInput::make('website_url')
                            ->label(__('Вебсайт'))
                            ->url()
                            ->maxLength(255)
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make('logo_url')
                    ->label(__('Логотип'))
                    ->circular()
                    ->defaultImageUrl(url('path/to/default-store-logo.jpg'))
                    ->sortable(),
                TextColumn::make('name')
                    ->label(__('Назва'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.admin.resources.stores.view', $record->id)),
                TextColumn::make('region')
                    ->label(__('Регіон'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('website_url')
                    ->label(__('Вебсайт'))
                    ->url(fn ($record) => $record->website_url)
                    ->openUrlInNewTab()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('book_offers_count')
                    ->label(__('Кількість пропозицій книг'))
                    ->counts('bookOffers')
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
                SelectFilter::make('region')
                    ->label(__('Регіон'))
                    ->options(function () {
                        return Store::pluck('region')->filter()->unique()->sort()->mapWithKeys(fn ($region) => [$region => $region]);
                    })
                    ->multiple()
                    ->indicator(__('Регіон')),
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
                'region',
            ]);
    }

    public static function getRelations(): array
    {
        return [
            BookOffersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStores::route('/'),
            'create' => CreateStore::route('/create'),
            'view' => ViewStore::route('/{record}'),
            'edit' => EditStore::route('/{record}/edit'),
        ];
    }
}
