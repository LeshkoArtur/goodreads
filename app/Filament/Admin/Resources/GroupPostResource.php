<?php

namespace App\Filament\Admin\Resources;

use App\Enums\PostCategory;
use App\Enums\PostStatus;
use App\Filament\Admin\Resources\GroupPostResource\Pages;
use App\Models\GroupPost;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GroupPostResource extends Resource
{
    protected static ?string $model = GroupPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    protected static ?string $navigationGroup = 'Функціонал груп';

    protected static ?int $navigationSort = 22;

    public static function getModelLabel(): string
    {
        return 'Пост групи';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Пости груп';
    }

    public static function getNavigationLabel(): string
    {
        return 'Пости груп';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount(['comments', 'likes']);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Основна інформація')
                ->description('Основні дані про пост групи')
                ->schema([
                    Select::make('group_id')
                        ->label('Група')
                        ->relationship('group', 'name')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->columnSpan(1),
                    Select::make('user_id')
                        ->label('Автор')
                        ->relationship('user', 'username')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->columnSpan(1),
                    Textarea::make('content')
                        ->label('Контент')
                        ->required()
                        ->rows(6)
                        ->maxLength(5000)
                        ->columnSpanFull()
                        ->helperText('Максимум 5000 символів'),
                ])->columns(2),

            Section::make('Налаштування поста')
                ->description('Категорія, статус та параметри відображення')
                ->schema([
                    Select::make('category')
                        ->label('Категорія')
                        ->options(PostCategory::class)
                        ->native(false)
                        ->required()
                        ->columnSpan(1),
                    Select::make('post_status')
                        ->label('Статус')
                        ->options(PostStatus::class)
                        ->native(false)
                        ->default(PostStatus::PUBLISHED)
                        ->required()
                        ->columnSpan(1),
                    Toggle::make('is_pinned')
                        ->label('Закріплено')
                        ->default(false)
                        ->helperText('Закріплений пост відображається вгорі списку')
                        ->columnSpan(1),
                ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('content')
                    ->label('Контент')
                    ->limit(60)
                    ->searchable()
                    ->tooltip(fn (GroupPost $record): string => $record->content)
                    ->wrap(),
                TextColumn::make('group.name')
                    ->label('Група')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('user.username')
                    ->label('Автор')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->label('Категорія')
                    ->badge()
                    ->color(fn (?PostCategory $state) => $state?->getColor())
                    ->sortable(),
                TextColumn::make('post_status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (?PostStatus $state) => $state?->getColor())
                    ->sortable(),
                IconColumn::make('is_pinned')
                    ->label('Закріплено')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('comments_count')
                    ->label('Коментарів')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('likes_count')
                    ->label('Лайків')
                    ->badge()
                    ->color('success')
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
                SelectFilter::make('group')
                    ->label('Група')
                    ->relationship('group', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                SelectFilter::make('category')
                    ->label('Категорія')
                    ->options(PostCategory::class)
                    ->native(false)
                    ->multiple(),
                SelectFilter::make('post_status')
                    ->label('Статус')
                    ->options(PostStatus::class)
                    ->native(false)
                    ->multiple(),
                TernaryFilter::make('is_pinned')
                    ->label('Закріплено')
                    ->placeholder('Всі пости')
                    ->trueLabel('Тільки закріплені')
                    ->falseLabel('Тільки незакріплені'),
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
            GroupPostResource\RelationManagers\CommentsRelationManager::class,
            GroupPostResource\RelationManagers\LikesRelationManager::class,
            GroupPostResource\RelationManagers\FavoritesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGroupPosts::route('/'),
            'create' => Pages\CreateGroupPost::route('/create'),
            'view' => Pages\ViewGroupPost::route('/{record}'),
            'edit' => Pages\EditGroupPost::route('/{record}/edit'),
        ];
    }
}
