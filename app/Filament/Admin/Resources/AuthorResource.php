<?php

namespace App\Filament\Admin\Resources;

use App\Enums\TypeOfWork;
use App\Filament\Admin\Resources\AuthorResource\Pages\CreateAuthor;
use App\Filament\Admin\Resources\AuthorResource\Pages\EditAuthor;
use App\Filament\Admin\Resources\AuthorResource\Pages\ListAuthors;
use App\Filament\Admin\Resources\AuthorResource\Pages\ViewAuthor;
use App\Filament\Admin\Resources\AuthorResource\RelationManagers\BooksRelationManager;
use App\Filament\Admin\Resources\AuthorResource\RelationManagers\QuestionsRelationManager;
use App\Filament\Admin\Resources\AuthorResource\RelationManagers\AnswersRelationManager;
use App\Filament\Admin\Resources\AuthorResource\RelationManagers\NominationsRelationManager;
use App\Models\Author;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Книгарня';

    protected static ?int $navigationSort = 3;

    public static function getNavigationLabel(): string
    {
        return __('Автори');
    }

    public static function getModelLabel(): string
    {
        return __('Автор');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Автори');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make(__('Автор'))
                    ->tabs([
                        Tabs\Tab::make(__('Основна інформація'))
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('Ім\'я'))
                                    ->required()
                                    ->maxLength(100),

                                Textarea::make('bio')
                                    ->label(__('Біографія'))
                                    ->maxLength(65535)
                                    ->nullable()
                                    ->columnSpanFull(),

                                DatePicker::make('birth_date')
                                    ->label(__('Дата народження'))
                                    ->nullable()
                                    ->maxDate(now()),

                                TextInput::make('birth_place')
                                    ->label(__('Місце народження'))
                                    ->maxLength(100)
                                    ->nullable(),

                                TextInput::make('nationality')
                                    ->label(__('Національність'))
                                    ->maxLength(50)
                                    ->nullable(),

                                DatePicker::make('death_date')
                                    ->label(__('Дата смерті'))
                                    ->nullable()
                                    ->maxDate(now()),

                                TextInput::make('website')
                                    ->label(__('Вебсайт'))
                                    ->url()
                                    ->maxLength(255)
                                    ->nullable(),

                                Select::make('type_of_work')
                                    ->label(__('Тип роботи'))
                                    ->options(
                                        collect(TypeOfWork::cases())
                                            ->mapWithKeys(fn ($case) => [$case->value => $case->getLabel()])
                                    )
                                    ->nullable()
                            ]),

                        Tabs\Tab::make(__('Медіа та соціальні мережі'))
                            ->schema([
                                FileUpload::make('profile_picture')
                                    ->label(__('Фото профілю'))
                                    ->directory('profile_picture')
                                    ->image()
                                    ->maxSize(2048)
                                    ->nullable(),

                                KeyValue::make('social_media_links')
                                    ->label(__('Соціальні мережі'))
                                    ->keyLabel(__('Платформа'))
                                    ->valueLabel(__('URL'))
                                    ->nullable(),

                                KeyValue::make('media_images')
                                    ->label(__('Медіа зображення'))
                                    ->keyLabel(__('Назва'))
                                    ->valueLabel(__('URL'))
                                    ->nullable(),

                                KeyValue::make('media_videos')
                                    ->label(__('Медіа відео'))
                                    ->keyLabel(__('Назва'))
                                    ->valueLabel(__('URL'))
                                    ->nullable(),

                                KeyValue::make('fun_facts')
                                    ->label(__('Цікаві факти'))
                                    ->keyLabel(__('Факт'))
                                    ->valueLabel(__('Опис'))
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

                ImageColumn::make('profile_picture')
                    ->label(__('Фото'))
                    ->getStateUsing(fn ($record) => $record->profile_picture)
                    ->circular()
                    ->defaultImageUrl(url('path/to/default-author-image.jpg')),

                TextColumn::make('name')
                    ->label(__('Ім\'я'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nationality')
                    ->label(__('Національність'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('birth_date')
                    ->label(__('Дата народження'))
                    ->date()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('death_date')
                    ->label(__('Дата смерті'))
                    ->date()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('type_of_work')
                    ->label(__('Тип роботи'))
                    ->badge()
                    ->formatStateUsing(fn (?TypeOfWork $state) => $state?->getLabel())
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('books_count')
                    ->label(__('Кількість книг'))
                    ->counts('books')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('posts_count')
                    ->label(__('Кількість публікацій'))
                    ->counts('posts')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('type_of_work')
                    ->label(__('Тип роботи'))
                    ->options(TypeOfWork::class)
                    ->multiple()
                    ->indicator(__('Тип роботи')),

                SelectFilter::make('nationality')
                    ->label(__('Національність'))
                    ->options(fn () => Author::pluck('nationality', 'nationality')->filter()->toArray())
                    ->multiple()
                    ->indicator(__('Національність')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
            ])
            ->defaultSort('name', 'asc')
            ->groups([
                'type_of_work',
                'nationality',
            ]);
    }

    public static function getRelations(): array
    {
        return [
            BooksRelationManager::class,
            QuestionsRelationManager::class,
            AnswersRelationManager::class,
            NominationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAuthors::route('/'),
            'create' => CreateAuthor::route('/create'),
            'view' => ViewAuthor::route('/{record}'),
            'edit' => EditAuthor::route('/{record}/edit'),
        ];
    }
}
