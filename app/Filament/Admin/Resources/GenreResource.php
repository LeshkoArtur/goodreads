<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\GenreResource\Pages;
use App\Models\Genre;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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

class GenreResource extends Resource
{
    protected static ?string $model = Genre::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Основні сутності';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return 'Жанр';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Жанри';
    }

    public static function getNavigationLabel(): string
    {
        return 'Жанри';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'description'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Батьківський' => $record->parent?->name ?? '—',
            'Книг' => $record->books_count ?? 0,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount(['books', 'children']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Інформація про жанр')
                    ->description('Базові дані про літературний жанр')
                    ->schema([
                        TextInput::make('name')
                            ->label('Назва жанру')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Унікальна назва жанру'),
                        Select::make('parent_id')
                            ->label('Батьківський жанр')
                            ->relationship('parent', 'name')
                            ->searchable()
                            ->preload()
                            ->helperText('Оберіть батьківський жанр, якщо цей є підкатегорією'),
                        Textarea::make('description')
                            ->label('Опис жанру')
                            ->rows(4)
                            ->maxLength(1000)
                            ->helperText('Детальний опис жанру (до 1000 символів)')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Назва')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('parent.name')
                    ->label('Батьківський жанр')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->placeholder('—')
                    ->toggleable(),
                TextColumn::make('books_count')
                    ->label('Книг')
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('children_count')
                    ->label('Підкатегорій')
                    ->badge()
                    ->color('warning')
                    ->sortable()
                    ->toggleable(),
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
                SelectFilter::make('parent')
                    ->label('Батьківський жанр')
                    ->relationship('parent', 'name')
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
            ->defaultSort('name', 'asc')
            ->striped()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();
    }

    public static function getRelations(): array
    {
        return [
            GenreResource\RelationManagers\BooksRelationManager::class,
            GenreResource\RelationManagers\SubgenresRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGenres::route('/'),
            'create' => Pages\CreateGenre::route('/create'),
            'view' => Pages\ViewGenre::route('/{record}'),
            'edit' => Pages\EditGenre::route('/{record}/edit'),
        ];
    }
}
