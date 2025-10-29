<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LikeResource\Pages;
use App\Models\AuthorAnswer;
use App\Models\Comment;
use App\Models\GroupPost;
use App\Models\Like;
use App\Models\Post;
use App\Models\Quote;
use App\Models\Rating;
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

class LikeResource extends Resource
{
    protected static ?string $model = Like::class;

    protected static ?string $navigationIcon = 'heroicon-o-hand-thumb-up';

    protected static ?string $navigationGroup = 'Взаємодія користувача';

    protected static ?int $navigationSort = 14;

    public static function getModelLabel(): string
    {
        return 'Лайк';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Лайки';
    }

    public static function getNavigationLabel(): string
    {
        return 'Лайки';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'likeable']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Лайк')
                    ->description('Інформація про лайк користувача')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'username')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Користувач')
                            ->helperText('Користувач, який поставив лайк'),
                        MorphToSelect::make('likeable')
                            ->label('Об\'єкт лайку')
                            ->types([
                                MorphToSelect\Type::make(Comment::class)->titleAttribute('content')->label('Коментар'),
                                MorphToSelect\Type::make(Post::class)->titleAttribute('title')->label('Пост'),
                                MorphToSelect\Type::make(GroupPost::class)->titleAttribute('title')->label('Пост в групі'),
                                MorphToSelect\Type::make(Quote::class)->titleAttribute('text')->label('Цитата'),
                                MorphToSelect\Type::make(Rating::class)->titleAttribute('rating')->label('Оцінка'),
                                MorphToSelect\Type::make(AuthorAnswer::class)->titleAttribute('content')->label('Відповідь автора'),
                            ])
                            ->required()
                            ->searchable()
                            ->preload(),
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
                TextColumn::make('likeable_type')
                    ->label('Тип')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Comment::class => 'Коментар',
                        Post::class => 'Пост',
                        GroupPost::class => 'Пост в групі',
                        Quote::class => 'Цитата',
                        Rating::class => 'Оцінка',
                        AuthorAnswer::class => 'Відповідь автора',
                        default => $state,
                    })
                    ->badge(),
                TextColumn::make('likeable.title')
                    ->label('Назва')
                    ->searchable()
                    ->sortable(),
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
                SelectFilter::make('likeable_type')
                    ->options([
                        Comment::class => 'Коментар',
                        Post::class => 'Пост',
                        GroupPost::class => 'Пост в групі',
                        Quote::class => 'Цитата',
                        Rating::class => 'Оцінка',
                        AuthorAnswer::class => 'Відповідь автора',
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
            'index' => Pages\ListLikes::route('/'),
            'create' => Pages\CreateLike::route('/create'),
            'view' => Pages\ViewLike::route('/{record}'),
            'edit' => Pages\EditLike::route('/{record}/edit'),
        ];
    }
}
