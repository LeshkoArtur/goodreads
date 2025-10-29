<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ShelfResource\Pages;
use App\Models\Shelf;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ShelfResource extends Resource
{
    protected static ?string $model = Shelf::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationGroup = 'Взаємодія користувача';

    protected static ?int $navigationSort = 12;

    public static function getModelLabel(): string
    {
        return 'Полиця';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Полиці';
    }

    public static function getNavigationLabel(): string
    {
        return 'Полиці';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'user.username'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Користувач' => $record->user->username,
            'Книг' => $record->user_books_count ?? 0,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount(['userBooks']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Інформація про полицю')
                    ->description('Персональна полиця користувача для організації книг')
                    ->schema([
                        Select::make('user_id')
                            ->label('Власник полиці')
                            ->helperText('Користувач, якому належить полиця')
                            ->relationship('user', 'username')
                            ->required()
                            ->searchable()
                            ->preload(),
                        TextInput::make('name')
                            ->label('Назва полиці')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Наприклад: "Хочу прочитати", "Улюблені", "Прочитано 2024"'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Назва полиці')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('user.username')
                    ->label('Користувач')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user_books_count')
                    ->label('Книг на полиці')
                    ->badge()
                    ->color('success')
                    ->sortable(),
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
                SelectFilter::make('user')
                    ->label('Користувач')
                    ->relationship('user', 'username')
                    ->searchable()
                    ->preload()
                    ->multiple(),
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
            ->striped()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();
    }

    public static function getRelations(): array
    {
        return [
            ShelfResource\RelationManagers\BooksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShelves::route('/'),
            'create' => Pages\CreateShelf::route('/create'),
            'view' => Pages\ViewShelf::route('/{record}'),
            'edit' => Pages\EditShelf::route('/{record}/edit'),
        ];
    }
}
