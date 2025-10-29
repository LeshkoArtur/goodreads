<?php

namespace App\Filament\Admin\Resources;

use App\Enums\PostStatus;
use App\Enums\PostType;
use App\Filament\Admin\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Взаємодія користувача';

    protected static ?int $navigationSort = 16;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getModelLabel(): string
    {
        return 'Пост';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Пости';
    }

    public static function getNavigationLabel(): string
    {
        return 'Пости';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'content', 'user.username', 'book.title'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->title;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Автор' => $record->user?->username ?? '—',
            'Тип' => $record->type?->getLabel() ?? '—',
            'Статус' => $record->status?->getLabel() ?? '—',
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount(['comments', 'likes', 'favorites']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основна інформація')
                    ->description('Основний контент посту')
                    ->schema([
                        Select::make('user_id')
                            ->label('Автор')
                            ->relationship('user', 'username')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(2),
                        FileUpload::make('cover_image')
                            ->label('Обкладинка')
                            ->image()
                            ->disk('public')
                            ->directory('posts')
                            ->imageEditor()
                            ->columnSpan(1),
                        TextInput::make('title')
                            ->label('Заголовок')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        RichEditor::make('content')
                            ->label('Контент')
                            ->required()
                            ->toolbarButtons(['bold', 'italic', 'link', 'bulletList', 'orderedList', 'h2', 'h3'])
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Section::make('Метадані')
                    ->schema([
                        Select::make('type')
                            ->label('Тип посту')
                            ->options(PostType::class)
                            ->required()
                            ->native(false),
                        Select::make('status')
                            ->label('Статус')
                            ->options(PostStatus::class)
                            ->required()
                            ->default(PostStatus::DRAFT)
                            ->native(false),
                        DateTimePicker::make('published_at')
                            ->label('Дата публікації')
                            ->native(false)
                            ->displayFormat('d/m/Y H:i'),
                    ])
                    ->columns(3),

                Section::make("Зв'язки")
                    ->schema([
                        Select::make('book_id')
                            ->label('Книга')
                            ->relationship('book', 'title')
                            ->searchable()
                            ->preload()
                            ->helperText('Оберіть книгу, якщо пост про неї'),
                        Select::make('author_id')
                            ->label('Автор (письменник)')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->preload()
                            ->helperText('Оберіть автора, якщо пост про нього'),
                        Select::make('tag_ids')
                            ->label('Теги')
                            ->relationship('tags', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Назва тегу')
                                    ->required(),
                            ]),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->label('Обкладинка')
                    ->disk('public')
                    ->size(50),
                TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(40),
                TextColumn::make('user.username')
                    ->label('Автор')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('type')
                    ->label('Тип')
                    ->badge()
                    ->color(fn (?PostType $state): string|array|null => $state?->getColor())
                    ->toggleable(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (?PostStatus $state): string|array|null => $state?->getColor())
                    ->sortable(),
                TextColumn::make('book.title')
                    ->label('Книга')
                    ->searchable()
                    ->limit(30)
                    ->toggleable(),
                TextColumn::make('comments_count')
                    ->label('Коментарів')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('likes_count')
                    ->label('Лайків')
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('published_at')
                    ->label('Опубліковано')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Тип')
                    ->options(PostType::class)
                    ->native(false),
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(PostStatus::class)
                    ->native(false),
                SelectFilter::make('user')
                    ->label('Автор')
                    ->relationship('user', 'username')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                SelectFilter::make('book')
                    ->label('Книга')
                    ->relationship('book', 'title')
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
            PostResource\RelationManagers\CommentsRelationManager::class,
            PostResource\RelationManagers\LikesRelationManager::class,
            PostResource\RelationManagers\FavoritesRelationManager::class,
            PostResource\RelationManagers\TagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
