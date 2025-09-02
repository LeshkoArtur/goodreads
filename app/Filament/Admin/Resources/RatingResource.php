<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RatingResource\Pages\CreateRating;
use App\Filament\Admin\Resources\RatingResource\Pages\EditRating;
use App\Filament\Admin\Resources\RatingResource\Pages\ListRatings;
use App\Filament\Admin\Resources\RatingResource\Pages\ViewRating;
use App\Filament\Admin\Resources\RatingResource\RelationManagers\CommentsRelationManager;
use App\Filament\Admin\Resources\RatingResource\RelationManagers\LikesRelationManager;
use App\Models\Rating;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RatingResource extends Resource
{
    protected static ?string $model = Rating::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationGroup = 'Книги';

    protected static ?int $navigationSort = 3;

    public static function getNavigationLabel(): string
    {
        return __('Оцінки');
    }

    public static function getModelLabel(): string
    {
        return __('Оцінка');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Оцінки');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make(__('Оцінка'))
                    ->tabs([
                        Tabs\Tab::make(__('Основна інформація'))
                            ->schema([
                                Select::make('user_id')
                                    ->label(__('Користувач'))
                                    ->relationship('user', 'username')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Select::make('book_id')
                                    ->label(__('Книга'))
                                    ->relationship('book', 'title')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Select::make('rating')
                                    ->label(__('Оцінка'))
                                    ->options([
                                        1 => '1',
                                        2 => '2',
                                        3 => '3',
                                        4 => '4',
                                        5 => '5',
                                    ])
                                    ->required(),
                                Textarea::make('review')
                                    ->label(__('Рецензія'))
                                    ->maxLength(5000)
                                    ->nullable()
                                    ->columnSpanFull(),
                            ]),
                    ])
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
                TextColumn::make('user.username')
                    ->label(__('Користувач'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.admin.resources.users.view', $record->user_id)),
                TextColumn::make('book.title')
                    ->label(__('Книга'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.admin.resources.books.view', $record->book_id)),
                TextColumn::make('rating')
                    ->label(__('Оцінка'))
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match ($state) {
                        1, 2 => 'danger',
                        3 => 'warning',
                        4, 5 => 'success',
                    }),
                TextColumn::make('review')
                    ->label(__('Рецензія'))
                    ->limit(50)
                    ->tooltip(fn (?string $state): ?string => $state)
                    ->searchable(),
                TextColumn::make('comments_count')
                    ->label(__('Кількість коментарів'))
                    ->counts('comments')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('likes_count')
                    ->label(__('Кількість лайків'))
                    ->counts('likes')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('favorites_count')
                    ->label(__('Кількість у вибране'))
                    ->counts('favorites')
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
                SelectFilter::make('user')
                    ->label(__('Користувач'))
                    ->relationship('user', 'username')
                    ->searchable()
                    ->multiple()
                    ->indicator(__('Користувач')),
                SelectFilter::make('book')
                    ->label(__('Книга'))
                    ->relationship('book', 'title')
                    ->searchable()
                    ->multiple()
                    ->indicator(__('Книга')),
                SelectFilter::make('rating')
                    ->label(__('Оцінка'))
                    ->options([
                        1 => '1',
                        2 => '2',
                        3 => '3',
                        4 => '4',
                        5 => '5',
                    ])
                    ->multiple()
                    ->indicator(__('Оцінка')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label(__('Переглянути')),
                Tables\Actions\EditAction::make()->label(__('Редагувати')),
                Tables\Actions\DeleteAction::make()->label(__('Видалити')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label(__('Видалити вибрані')),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->groups([
                'rating',
                'book_id',
                'user_id',
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CommentsRelationManager::class,
            LikesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRatings::route('/'),
            'create' => CreateRating::route('/create'),
            'view' => ViewRating::route('/{record}'),
            'edit' => EditRating::route('/{record}/edit'),
        ];
    }
}
