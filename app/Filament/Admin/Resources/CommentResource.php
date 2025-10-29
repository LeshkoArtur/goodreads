<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CommentResource\Pages;
use App\Models\Comment;
use App\Models\GroupPost;
use App\Models\Post;
use App\Models\Quote;
use App\Models\Rating;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?string $navigationGroup = 'Взаємодія користувача';

    protected static ?int $navigationSort = 15;

    public static function getModelLabel(): string
    {
        return 'Коментар';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Коментарі';
    }

    public static function getNavigationLabel(): string
    {
        return 'Коментарі';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['content', 'user.username'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return substr($record->content, 0, 60).'...';
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Користувач' => $record->user->username,
            'Тип' => class_basename($record->commentable_type),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount(['replies']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Коментар')
                    ->description('Інформація про коментар користувача')
                    ->schema([
                        Select::make('user_id')
                            ->label('Користувач')
                            ->relationship('user', 'username')
                            ->required()
                            ->searchable()
                            ->preload(),
                        MorphToSelect::make('commentable')
                            ->label('Об\'єкт коментаря')
                            ->types([
                                MorphToSelect\Type::make(Post::class)
                                    ->titleAttribute('title'),
                                MorphToSelect\Type::make(Rating::class)
                                    ->titleAttribute('rating'),
                                MorphToSelect\Type::make(Quote::class)
                                    ->titleAttribute('text'),
                                MorphToSelect\Type::make(GroupPost::class)
                                    ->titleAttribute('title'),
                            ])
                            ->required()
                            ->searchable()
                            ->preload(),
                        Textarea::make('content')
                            ->label('Текст коментаря')
                            ->required()
                            ->rows(5)
                            ->maxLength(2000)
                            ->columnSpanFull(),
                        Select::make('parent_id')
                            ->label('Батьківський коментар')
                            ->helperText('Залиште порожнім для коментаря верхнього рівня')
                            ->relationship('parent', 'content')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('content')
                    ->label('Коментар')
                    ->searchable()
                    ->limit(80)
                    ->wrap(),
                TextColumn::make('user.username')
                    ->label('Користувач')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('commentable_type')
                    ->label('Тип')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'App\Models\Post' => 'Пост',
                        'App\Models\Rating' => 'Рейтинг',
                        'App\Models\Quote' => 'Цитата',
                        'App\Models\GroupPost' => 'Пост групи',
                        default => class_basename($state),
                    })
                    ->badge()
                    ->color('info'),
                TextColumn::make('commentable.title')
                    ->label('Об\'єкт')
                    ->formatStateUsing(function ($record) {
                        $commentable = $record->commentable;
                        if ($commentable instanceof Post) {
                            return $commentable->title;
                        } elseif ($commentable instanceof Rating) {
                            return "Оцінка: {$commentable->rating}";
                        } elseif ($commentable instanceof Quote) {
                            return strlen($commentable->text) > 50
                                ? substr($commentable->text, 0, 50).'...'
                                : $commentable->text;
                        } elseif ($commentable instanceof GroupPost) {
                            return $commentable->title;
                        }

                        return 'Невідомий об\'єкт';
                    })
                    ->searchable(),
                TextColumn::make('replies_count')
                    ->label('Відповідей')
                    ->badge()
                    ->color('warning')
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
                SelectFilter::make('commentable_type')
                    ->label('Тип об\'єкту')
                    ->options([
                        'App\\Models\\Post' => 'Пост',
                        'App\\Models\\Rating' => 'Рейтинг',
                        'App\\Models\\Quote' => 'Цитата',
                        'App\\Models\\GroupPost' => 'Пост групи',
                    ])
                    ->native(false),
            ])
            ->actions([
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
            CommentResource\RelationManagers\RepliesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
