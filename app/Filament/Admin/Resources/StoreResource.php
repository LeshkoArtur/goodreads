<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\StoreResource\Pages;
use App\Models\Store;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StoreResource extends Resource
{
    protected static ?string $model = Store::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationGroup = 'Електронна комерція';

    protected static ?int $navigationSort = 35;

    public static function getModelLabel(): string
    {
        return 'Магазин';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Магазини';
    }

    public static function getNavigationLabel(): string
    {
        return 'Магазини';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Інформація про магазин')
                    ->description('Базові дані інтернет-магазину')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Назва магазину')
                            ->helperText('Повна назва магазину')
                            ->columnSpan(2),
                        FileUpload::make('logo_url')
                            ->image()
                            ->disk('public')
                            ->directory('stores')
                            ->imageEditor()
                            ->label('Логотип')
                            ->columnSpan(1),
                        TextInput::make('website_url')
                            ->url()
                            ->maxLength(255)
                            ->label('Веб-сайт')
                            ->prefix('https://')
                            ->helperText('Посилання на офіційний сайт'),
                        TextInput::make('region')
                            ->maxLength(255)
                            ->label('Регіон')
                            ->helperText('Країна або регіон роботи'),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo_url')
                    ->disk('public')
                    ->label('Логотип'),
                TextColumn::make('name')
                    ->label('Назва')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('website_url')
                    ->label('Веб-сайт')
                    ->searchable(),
                TextColumn::make('region')
                    ->label('Регіон')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Оновлено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            ->defaultSort('name')
            ->striped();
    }

    public static function getRelations(): array
    {
        return [
            StoreResource\RelationManagers\BookOffersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStores::route('/'),
            'create' => Pages\CreateStore::route('/create'),
            'view' => Pages\ViewStore::route('/{record}'),
            'edit' => Pages\EditStore::route('/{record}/edit'),
        ];
    }
}
