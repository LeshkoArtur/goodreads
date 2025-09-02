<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ShelfResource\Pages\CreateShelf;
use App\Filament\Admin\Resources\ShelfResource\Pages\EditShelf;
use App\Filament\Admin\Resources\ShelfResource\Pages\ListShelves;
use App\Filament\Admin\Resources\ShelfResource\Pages\ViewShelf;
use App\Filament\Admin\Resources\ShelfResource\RelationManagers\UserBooksRelationManager;
use App\Models\Shelf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ShelfResource extends Resource
{
    protected static ?string $model = Shelf::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Полиці';

    protected static ?int $navigationSort = 7;

    public static function getNavigationLabel(): string
    {
        return __('Полиці');
    }

    public static function getModelLabel(): string
    {
        return __('Полиця');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Полиці');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label(__('Користувач'))
                    ->relationship('user', 'username')
                    ->required()
                    ->searchable()
                    ->preload(),

                TextInput::make('name')
                    ->label(__('Назва'))
                    ->required()
                    ->maxLength(255)
                    ->unique(Shelf::class, 'name', ignoreRecord: true),
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

                TextColumn::make('name')
                    ->label(__('Назва'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.admin.resources.shelves.view', $record->id)),

                TextColumn::make('user.username')
                    ->label(__('Користувач'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->user ? route('filament.admin.resources.users.view', $record->user_id) : null),

                TextColumn::make('userBooks_count')
                    ->label(__('Кількість книг'))
                    ->counts('userBooks')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('Дата створення'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('Дата оновлення'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->label(__('Користувач'))
                    ->relationship('user', 'username')
                    ->multiple()
                    ->indicator(__('Користувач')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name', 'asc')
            ->groups([
                'user_id',
            ]);
    }

    public static function getRelations(): array
    {
        return [
            UserBooksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListShelves::route('/'),
            'create' => CreateShelf::route('/create'),
            'view' => ViewShelf::route('/{record}'),
            'edit' => EditShelf::route('/{record}/edit'),
        ];
    }
}
