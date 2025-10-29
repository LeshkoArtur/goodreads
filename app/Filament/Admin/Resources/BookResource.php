<?php

namespace App\Filament\Admin\Resources;

use App\Enums\AgeRestriction;
use App\Filament\Admin\Resources\BookResource\Pages;
use App\Models\Book;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Основні сутності';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getModelLabel(): string
    {
        return 'Книга';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Книги';
    }

    public static function getNavigationLabel(): string
    {
        return 'Книги';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'description', 'plot', 'authors.name', 'genres.name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->title;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $authors = $record->authors->pluck('name')->take(3)->join(', ');

        return [
            'Автори' => $authors ?: '—',
            'Рейтинг' => $record->average_rating ? $record->average_rating.' ⭐' : '—',
            'Сторінок' => $record->page_count ?: '—',
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount(['ratings', 'quotes', 'characters', 'userBooks']);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->label('Обкладинка')
                    ->disk('public')
                    ->size(60),
                TextColumn::make('title')
                    ->label('Назва')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(40)
                    ->tooltip(fn (Book $record): ?string => $record->title),
                TextColumn::make('authors.name')
                    ->label('Автори')
                    ->searchable()
                    ->limit(30)
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->expandableLimitedList()
                    ->toggleable(),
                TextColumn::make('genres.name')
                    ->label('Жанри')
                    ->badge()
                    ->separator(',')
                    ->limit(20)
                    ->toggleable(),
                TextColumn::make('series.title')
                    ->label('Серія')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('average_rating')
                    ->label('Рейтинг')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state >= 4.5 => 'success',
                        $state >= 3.5 => 'warning',
                        $state >= 2.5 => 'info',
                        default => 'danger',
                    })
                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 1).' ⭐' : '—'),
                TextColumn::make('page_count')
                    ->label('Сторінок')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                IconColumn::make('is_bestseller')
                    ->label('Бестселер')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('age_restriction')
                    ->label('Віковий рейтинг')
                    ->badge()
                    ->color(fn (?AgeRestriction $state): string|array|null => $state?->getColor())
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('ratings_count')
                    ->label('Оцінок')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                SelectFilter::make('series')
                    ->label('Серія')
                    ->relationship('series', 'title')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                SelectFilter::make('age_restriction')
                    ->label('Віковий рейтинг')
                    ->options(AgeRestriction::class)
                    ->native(false)
                    ->multiple(),
                TernaryFilter::make('is_bestseller')
                    ->label('Бестселер'),
                Filter::make('average_rating')
                    ->form([
                        TextInput::make('rating_from')
                            ->label('Рейтинг від')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(5),
                        TextInput::make('rating_to')
                            ->label('Рейтинг до')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(5),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['rating_from'], fn (Builder $query, $rating) => $query->where('average_rating', '>=', $rating))
                            ->when($data['rating_to'], fn (Builder $query, $rating) => $query->where('average_rating', '<=', $rating));
                    }),
                SelectFilter::make('genres')
                    ->label('Жанри')
                    ->relationship('genres', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                SelectFilter::make('authors')
                    ->label('Автори')
                    ->relationship('authors', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основна інформація')
                    ->description('Базові дані про книгу')
                    ->schema([
                        TextInput::make('title')
                            ->label('Назва книги')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Повна назва книги')
                            ->columnSpan(2),
                        FileUpload::make('cover_image')
                            ->label('Обкладинка')
                            ->image()
                            ->disk('public')
                            ->directory('covers')
                            ->imageEditor()
                            ->imageCropAspectRatio('2:3')
                            ->imageResizeTargetWidth('400')
                            ->imageResizeTargetHeight('600')
                            ->helperText('Зображення обкладинки 400x600px')
                            ->columnSpan(1),
                        Textarea::make('description')
                            ->label('Короткий опис')
                            ->rows(3)
                            ->maxLength(1000)
                            ->helperText('Короткий опис книги (до 1000 символів)')
                            ->columnSpanFull(),
                        RichEditor::make('plot')
                            ->label('Сюжет')
                            ->toolbarButtons(['bold', 'italic', 'link', 'bulletList', 'orderedList'])
                            ->helperText('Детальний опис сюжету книги')
                            ->columnSpanFull(),
                        RichEditor::make('history')
                            ->label('Історія створення')
                            ->toolbarButtons(['bold', 'italic', 'link', 'bulletList', 'orderedList'])
                            ->helperText('Цікаві факти про написання книги')
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Section::make('Серія та класифікація')
                    ->description('Належність до серії та вікові обмеження')
                    ->schema([
                        Select::make('series_id')
                            ->label('Серія')
                            ->relationship('series', 'title')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('title')
                                    ->label('Назва серії')
                                    ->required(),
                                Textarea::make('description')
                                    ->label('Опис')
                                    ->rows(3),
                            ])
                            ->helperText('Оберіть серію або створіть нову')
                            ->columnSpan(1)
                            ->reactive(),
                        TextInput::make('number_in_series')
                            ->label('Номер у серії')
                            ->numeric()
                            ->minValue(1)
                            ->visible(fn (callable $get) => filled($get('series_id')))
                            ->required(fn (callable $get) => filled($get('series_id')))
                            ->helperText('Порядковий номер книги в серії')
                            ->columnSpan(1),
                        Select::make('age_restriction')
                            ->label('Віковий рейтинг')
                            ->options(AgeRestriction::class)
                            ->required()
                            ->default(AgeRestriction::NONE)
                            ->native(false)
                            ->helperText('Рекомендований вік читачів')
                            ->columnSpan(1),
                    ])
                    ->columns(3),

                Section::make('Деталі')
                    ->description('Додаткові властивості книги')
                    ->schema([
                        TextInput::make('page_count')
                            ->label('Кількість сторінок')
                            ->numeric()
                            ->minValue(1)
                            ->helperText('Загальна кількість сторінок')
                            ->columnSpan(1),
                        TagsInput::make('languages')
                            ->label('Мови')
                            ->placeholder('Додати мову')
                            ->helperText('Наприклад: Українська, English, Polska')
                            ->columnSpan(1),
                        Toggle::make('is_bestseller')
                            ->label('Бестселер')
                            ->default(false)
                            ->helperText('Чи є книга бестселером')
                            ->columnSpan(1),
                    ])
                    ->columns(3),

                Section::make('Додаткова інформація')
                    ->description('Цікаві факти та адаптації книги')
                    ->schema([
                        Repeater::make('fun_facts')
                            ->label('Цікаві факти')
                            ->simple(Textarea::make('fact')
                                ->label('Факт')
                                ->rows(2)
                                ->required())
                            ->columnSpanFull()
                            ->defaultItems(0)
                            ->addActionLabel('Додати факт'),
                        Repeater::make('adaptations')
                            ->label('Адаптації')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Назва')
                                    ->required(),
                                Select::make('type')
                                    ->label('Тип')
                                    ->options([
                                        'film' => 'Фільм',
                                        'tv_series' => 'Серіал',
                                        'theater' => 'Театр',
                                        'game' => 'Гра',
                                        'audiobook' => 'Аудіокнига',
                                        'other' => 'Інше',
                                    ])
                                    ->required()
                                    ->native(false),
                                TextInput::make('year')
                                    ->label('Рік')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue(now()->year + 10),
                            ])
                            ->columnSpanFull()
                            ->defaultItems(0)
                            ->addActionLabel('Додати адаптацію')
                            ->columns(3),
                    ])
                    ->collapsed()
                    ->collapsible(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            BookResource\RelationManagers\AuthorsRelationManager::class,
            BookResource\RelationManagers\GenresRelationManager::class,
            BookResource\RelationManagers\PublishersRelationManager::class,
            BookResource\RelationManagers\RatingsRelationManager::class,
            BookResource\RelationManagers\QuotesRelationManager::class,
            BookResource\RelationManagers\CharactersRelationManager::class,
            BookResource\RelationManagers\CollectionsRelationManager::class,
            BookResource\RelationManagers\PostsRelationManager::class,
            BookResource\RelationManagers\NotesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'view' => Pages\ViewBook::route('/{record}'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
