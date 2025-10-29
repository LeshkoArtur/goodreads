<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\FavoriteResource\Pages;
use App\Models\Author;
use App\Models\Book;
use App\Models\Favorite;
use App\Models\Quote;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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

class FavoriteResource extends Resource
{
    protected static ?string $model = Favorite::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationGroup = 'Взаємодія користувача';

    protected static ?int $navigationSort = 13;

    public static function getModelLabel(): string
    {
        return 'Обране';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Обрані';
    }

    public static function getNavigationLabel(): string
    {
        return 'Обрані';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'favoriteable']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Обране')
                    ->description('Додавання об\'єкта до обраного')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'username')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Користувач')
                            ->helperText('Користувач, який додає до обраного'),
                        MorphToSelect::make('favoriteable')
                            ->label('Об\'єкт')
                            ->types([
                                MorphToSelect\Type::make(Book::class)
                                    ->titleAttribute('title'),
                                MorphToSelect\Type::make(Author::class)
                                    ->titleAttribute('name'),
                                MorphToSelect\Type::make(Quote::class)
                                    ->titleAttribute('text'),
                            ])
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.username')
                    ->label('Користувач')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('favoriteable_type')
                    ->label('Тип об\'єкта')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'App\Models\Book' => 'Книга',
                        'App\Models\Author' => 'Автор',
                        'App\Models\Quote' => 'Цитата',
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('favoriteable.title')
                    ->label('Назва')
                    ->formatStateUsing(function ($record) {
                        $favoriteable = $record->favoriteable;
                        if ($favoriteable instanceof Book) {
                            return $favoriteable->title;
                        } elseif ($favoriteable instanceof Author) {
                            return $favoriteable->name;
                        } elseif ($favoriteable instanceof Quote) {
                            return strlen($favoriteable->text) > 50
                                ? substr($favoriteable->text, 0, 50).'...'
                                : $favoriteable->text;
                        }

                        return 'Невідомий об\'єкт';
                    })
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user')
                    ->relationship('user', 'username')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->label('Користувач'),
                SelectFilter::make('favoriteable_type')
                    ->options([
                        Book::class => 'Книга',
                        Author::class => 'Автор',
                        Quote::class => 'Цитата',
                    ])
                    ->label('Тип'),
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
            'index' => Pages\ListFavorites::route('/'),
            'create' => Pages\CreateFavorite::route('/create'),
            'view' => Pages\ViewFavorite::route('/{record}'),
            'edit' => Pages\EditFavorite::route('/{record}/edit'),
        ];
    }
}
