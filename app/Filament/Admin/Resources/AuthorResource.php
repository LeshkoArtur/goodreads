<?php

namespace App\Filament\Admin\Resources;

use App\Enums\TypeOfWork;
use App\Filament\Admin\Resources\AuthorResource\Pages;
use App\Models\Author;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'Основні сутності';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return 'Автор';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Автори';
    }

    public static function getNavigationLabel(): string
    {
        return 'Автори';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'bio', 'nationality', 'birth_place'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Тип роботи' => $record->type_of_work?->getLabel() ?? '—',
            'Національність' => $record->nationality ?: '—',
            'Книг' => $record->books_count ?? 0,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount(['books', 'questions', 'answers', 'posts']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основна інформація')
                    ->description('Базові дані про автора')
                    ->schema([
                        TextInput::make('name')
                            ->label('Повне ім\'я')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Повне ім\'я автора (ім\'я та прізвище)')
                            ->columnSpan(2),
                        FileUpload::make('profile_picture')
                            ->label('Фото профілю')
                            ->image()
                            ->disk('public')
                            ->directory('authors')
                            ->imageEditor()
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('300')
                            ->imageResizeTargetHeight('300')
                            ->helperText('Квадратне фото 300x300px')
                            ->columnSpan(1)
                            ->afterStateHydrated(function (FileUpload $component, $state) {
                                if (is_array($state)) {
                                    $component->state(null);
                                } else {
                                    $component->state($state);
                                }
                            }),
                        RichEditor::make('bio')
                            ->label('Біографія')
                            ->toolbarButtons(['bold', 'italic', 'link', 'bulletList', 'orderedList'])
                            ->helperText('Коротка біографія автора')
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Section::make('Персональна інформація')
                    ->description('Особисті дані та контакти автора')
                    ->schema([
                        DatePicker::make('birth_date')
                            ->label('Дата народження')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->maxDate(now()),
                        TextInput::make('birth_place')
                            ->label('Місце народження')
                            ->maxLength(50),
                        DatePicker::make('death_date')
                            ->label('Дата смерті')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->maxDate(now())
                            ->afterOrEqual('birth_date'),
                        TextInput::make('nationality')
                            ->label('Національність')
                            ->maxLength(50),
                        Select::make('type_of_work')
                            ->label('Тип роботи')
                            ->options(TypeOfWork::class)
                            ->native(false)
                            ->searchable()
                            ->helperText('Основний тип літературної діяльності'),
                        TextInput::make('website')
                            ->label('Веб-сайт')
                            ->url()
                            ->maxLength(255)
                            ->prefix('https://'),
                    ])
                    ->columns(3),

                Section::make('Медіа')
                    ->description('Соціальні мережі та медіа-контент')
                    ->schema([
                        Repeater::make('social_media_links')
                            ->label('Соціальні мережі')
                            ->schema([
                                Select::make('platform')
                                    ->label('Платформа')
                                    ->options([
                                        'facebook' => 'Facebook',
                                        'twitter' => 'Twitter / X',
                                        'instagram' => 'Instagram',
                                        'linkedin' => 'LinkedIn',
                                        'tiktok' => 'TikTok',
                                        'youtube' => 'YouTube',
                                        'readloop' => 'readloop',
                                        'other' => 'Інше',
                                    ])
                                    ->required()
                                    ->native(false),
                                TextInput::make('url')
                                    ->label('URL')
                                    ->url()
                                    ->required(),
                            ])
                            ->columns(2)
                            ->columnSpanFull()
                            ->defaultItems(0)
                            ->addActionLabel('Додати соц. мережу'),
                        Repeater::make('media_images')
                            ->label('Зображення')
                            ->simple(FileUpload::make('image')
                                ->label('Зображення')
                                ->image()
                                ->disk('public')
                                ->directory('author-media')
                                ->afterStateHydrated(function (FileUpload $component, $state) {
                                    if (is_array($state)) {
                                        $component->state(null);
                                    } else {
                                        $component->state($state);
                                    }
                                }))
                            ->columnSpanFull()
                            ->defaultItems(0)
                            ->addActionLabel('Додати зображення'),
                        Repeater::make('media_videos')
                            ->label('Відео')
                            ->simple(TextInput::make('video_url')
                                ->label('URL відео')
                                ->url()
                                ->required())
                            ->columnSpanFull()
                            ->defaultItems(0)
                            ->addActionLabel('Додати відео'),
                    ])
                    ->collapsed()
                    ->collapsible(),

                Section::make('Цікаві факти')
                    ->description('Додаткова інформація про автора')
                    ->schema([
                        Repeater::make('fun_facts')
                            ->label('Факти')
                            ->simple(Textarea::make('fact')
                                ->label('Факт')
                                ->rows(2)
                                ->required())
                            ->columnSpanFull()
                            ->defaultItems(0)
                            ->addActionLabel('Додати факт'),
                    ])
                    ->collapsed()
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_picture')
                    ->label('Фото')
                    ->disk('public')
                    ->circular()
                    ->size(50),
                TextColumn::make('name')
                    ->label('Ім\'я')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Author $record): string => $record->type_of_work?->getLabel() ?? ''
                    ),
                TextColumn::make('type_of_work')
                    ->label('Тип роботи')
                    ->badge()
                    ->color(fn (?TypeOfWork $state): string|array|null => $state?->getColor())
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('nationality')
                    ->label('Національність')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('birth_date')
                    ->label('Дата народження')
                    ->date('d.m.Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('books_count')
                    ->label('Книг')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                TextColumn::make('questions_count')
                    ->label('Питань')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('answers_count')
                    ->label('Відповідей')
                    ->badge()
                    ->color('warning')
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
                SelectFilter::make('type_of_work')
                    ->label('Тип роботи')
                    ->options(TypeOfWork::class)
                    ->native(false)
                    ->multiple(),
                SelectFilter::make('nationality')
                    ->label('Національність')
                    ->options(function () {
                        return Author::query()
                            ->whereNotNull('nationality')
                            ->distinct()
                            ->pluck('nationality', 'nationality')
                            ->toArray();
                    })
                    ->searchable()
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
            AuthorResource\RelationManagers\BooksRelationManager::class,
            AuthorResource\RelationManagers\QuestionsRelationManager::class,
            AuthorResource\RelationManagers\AnswersRelationManager::class,
            AuthorResource\RelationManagers\NominationsRelationManager::class,
            AuthorResource\RelationManagers\PostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuthors::route('/'),
            'create' => Pages\CreateAuthor::route('/create'),
            'view' => Pages\ViewAuthor::route('/{record}'),
            'edit' => Pages\EditAuthor::route('/{record}/edit'),
        ];
    }
}
