<?php

namespace App\Filament\Admin\Resources;

use App\Enums\AgeRestriction;
use App\Filament\Admin\Resources\BookResource\Pages\CreateBook;
use App\Filament\Admin\Resources\BookResource\Pages\EditBook;
use App\Filament\Admin\Resources\BookResource\Pages\ListBooks;
use App\Filament\Admin\Resources\BookResource\Pages\ViewBook;
use App\Filament\Admin\Resources\BookResource\RelationManagers\AuthorsRelationManager;
use App\Filament\Admin\Resources\BookResource\RelationManagers\GenresRelationManager;
use App\Filament\Admin\Resources\BookResource\RelationManagers\PostsRelationManager;
use App\Filament\Admin\Resources\BookResource\RelationManagers\PublishersRelationManager;
use App\Filament\Admin\Resources\BookResource\RelationManagers\QuotesRelationManager;
use App\Filament\Admin\Resources\BookResource\RelationManagers\RatingsRelationManager;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Книги';

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __('Книги');
    }

    public static function getModelLabel(): string
    {
        return __('Книга');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Книги');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make(__('Книга'))
                    ->tabs([
                        Tabs\Tab::make(__('Основна інформація'))
                            ->schema([
                                TextInput::make('title')
                                    ->label(__('Назва'))
                                    ->required()
                                    ->maxLength(255),

                                Textarea::make('description')
                                    ->label(__('Опис'))
                                    ->maxLength(65535)
                                    ->nullable()
                                    ->columnSpanFull(),

                                Textarea::make('plot')
                                    ->label(__('Сюжет'))
                                    ->maxLength(65535)
                                    ->nullable()
                                    ->columnSpanFull(),

                                Textarea::make('history')
                                    ->label(__('Історія створення'))
                                    ->maxLength(65535)
                                    ->nullable()
                                    ->columnSpanFull(),

                                Select::make('series_id')
                                    ->label(__('Серія'))
                                    ->relationship('series', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->nullable(),

                                TextInput::make('number_in_series')
                                    ->label(__('Номер у серії'))
                                    ->numeric()
                                    ->minValue(1)
                                    ->nullable(),

                                TextInput::make('page_count')
                                    ->label(__('Кількість сторінок'))
                                    ->numeric()
                                    ->minValue(1)
                                    ->nullable(),
                            ]),

                        Tabs\Tab::make(__('Додаткові дані'))
                            ->schema([
                                KeyValue::make('languages')
                                    ->label(__('Мови'))
                                    ->keyLabel(__('Код мови'))
                                    ->valueLabel(__('Назва мови'))
                                    ->nullable(),

                                Forms\Components\FileUpload::make('cover_image')
                                    ->label(__('Обкладинка'))
                                    ->directory('cover_image')
                                    ->image()
                                    ->maxSize(2048)
                                    ->nullable(),

                                KeyValue::make('fun_facts')
                                    ->label(__('Цікаві факти'))
                                    ->keyLabel(__('Факт'))
                                    ->valueLabel(__('Опис'))
                                    ->nullable(),

                                KeyValue::make('adaptations')
                                    ->label(__('Екранізації'))
                                    ->keyLabel(__('Назва'))
                                    ->valueLabel(__('Опис'))
                                    ->nullable(),

                                Toggle::make('is_bestseller')
                                    ->label(__('Бестселер'))
                                    ->default(false),

                                TextInput::make('average_rating')
                                    ->label(__('Середній рейтинг'))
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(5)
                                    ->step(0.1)
                                    ->disabled()
                                    ->dehydrated(false),

                                Select::make('age_restriction')
                                    ->label(__('Вікове обмеження'))
                                    ->options(AgeRestriction::class)
                                    ->nullable(),
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

                ImageColumn::make('cover_image')
                    ->label(__('Обкладинка'))
                    ->getStateUsing(fn ($record) => $record->getFirstMediaUrl('cover_image'))
                    ->circular(),

                TextColumn::make('title')
                    ->label(__('Назва'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.admin.resources.books.view', $record->id)),

                TextColumn::make('series.name')
                    ->label(__('Серія'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('number_in_series')
                    ->label(__('Номер у серії'))
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('page_count')
                    ->label(__('Сторінки'))
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('average_rating')
                    ->label(__('Середній рейтинг'))
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('is_bestseller')
                    ->label(__('Бестселер'))
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('age_restriction')
                    ->label(__('Вікове обмеження'))
                    ->badge()
                    ->formatStateUsing(fn (?AgeRestriction $state) => $state?->getLabel())
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('ratings_count')
                    ->label(__('Кількість рейтингів'))
                    ->counts('ratings')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('notes_count')
                    ->label(__('Кількість нотаток'))
                    ->counts('notes')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('quotes_count')
                    ->label(__('Кількість цитат'))
                    ->counts('quotes')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('age_restriction')
                    ->label(__('Вікове обмеження'))
                    ->options(AgeRestriction::class)
                    ->multiple()
                    ->indicator(__('Вікове обмеження')),

                TernaryFilter::make('is_bestseller')
                    ->label(__('Бестселер'))
                    ->placeholder(__('Всі'))
                    ->trueLabel(__('Бестселери'))
                    ->falseLabel(__('Не бестселери'))
                    ->indicator(__('Бестселер')),

                SelectFilter::make('series_id')
                    ->label(__('Серія'))
                    ->relationship('series', 'name')
                    ->multiple()
                    ->indicator(__('Серія')),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
            ])
            ->defaultSort('title', 'asc')
            ->groups([
                'age_restriction',
                'is_bestseller',
                'series_id',
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AuthorsRelationManager::class,
            GenresRelationManager::class,
            PublishersRelationManager::class,
            RatingsRelationManager::class,
            QuotesRelationManager::class,
            PostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBooks::route('/'),
            'create' => CreateBook::route('/create'),
            'view' => ViewBook::route('/{record}'),
            'edit' => EditBook::route('/{record}/edit'),
        ];
    }
}
