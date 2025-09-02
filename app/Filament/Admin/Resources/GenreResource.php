<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\GenreResource\Pages\CreateGenre;
use App\Filament\Admin\Resources\GenreResource\Pages\EditGenre;
use App\Filament\Admin\Resources\GenreResource\Pages\ListGenres;
use App\Filament\Admin\Resources\GenreResource\Pages\ViewGenre;
use App\Filament\Admin\Resources\GenreResource\RelationManagers\BooksRelationManager;
use App\Models\Genre;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GenreResource extends Resource
{
    protected static ?string $model = Genre::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Жанри';

    protected static ?int $navigationSort = 5;

    public static function getNavigationLabel(): string
    {
        return __('Жанри');
    }

    public static function getModelLabel(): string
    {
        return __('Жанр');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Жанри');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('Назва'))
                    ->required()
                    ->maxLength(100),

                Select::make('parent_id')
                    ->label(__('Батьківський жанр'))
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                Textarea::make('description')
                    ->label(__('Опис'))
                    ->maxLength(65535)
                    ->nullable()
                    ->columnSpanFull(),
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
                    ->url(fn ($record) => route('filament.admin.resources.genres.view', $record->id)),

                TextColumn::make('parent.name')
                    ->label(__('Батьківський жанр'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('book_count')
                    ->label(__('Кількість книг'))
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
                SelectFilter::make('parent_id')
                    ->label(__('Батьківський жанр'))
                    ->relationship('parent', 'name')
                    ->multiple()
                    ->indicator(__('Батьківський жанр')),
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
                'parent_id',
            ]);
    }

    public static function getRelations(): array
    {
        return [
            BooksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGenres::route('/'),
            'create' => CreateGenre::route('/create'),
            'view' => ViewGenre::route('/{record}'),
            'edit' => EditGenre::route('/{record}/edit'),
        ];
    }
}
