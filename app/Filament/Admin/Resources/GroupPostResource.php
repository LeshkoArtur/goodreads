<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\GroupPostResource\Pages\CreateGroupPost;
use App\Filament\Admin\Resources\GroupPostResource\Pages\EditGroupPost;
use App\Filament\Admin\Resources\GroupPostResource\Pages\ListGroupPosts;
use App\Filament\Admin\Resources\GroupPostResource\Pages\ViewGroupPost;
use App\Filament\Admin\Resources\GroupPostResource\RelationManagers\CommentsRelationManager;
use App\Filament\Admin\Resources\GroupPostResource\RelationManagers\LikesRelationManager;
use App\Filament\Admin\Resources\GroupPostResource\RelationManagers\FavoritesRelationManager;
use App\Filament\Admin\Resources\GroupPostResource\RelationManagers\GroupModerationLogsRelationManager;
use App\Enums\PostCategory;
use App\Enums\PostStatus;
use App\Models\GroupPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class GroupPostResource extends Resource
{
    protected static ?string $model = GroupPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Публікації груп';

    protected static ?int $navigationSort = 11;

    public static function getNavigationLabel(): string
    {
        return __('Публікації груп');
    }

    public static function getModelLabel(): string
    {
        return __('Публікація групи');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Публікації груп');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('group_id')
                    ->label(__('Група'))
                    ->relationship('group', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                Select::make('user_id')
                    ->label(__('Користувач'))
                    ->relationship('user', 'username')
                    ->required()
                    ->searchable()
                    ->preload(),

                Textarea::make('content')
                    ->label(__('Контент'))
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),

                Toggle::make('is_pinned')
                    ->label(__('Закріплено'))
                    ->default(false),

                Select::make('category')
                    ->label(__('Категорія'))
                    ->options(PostCategory::class)
                    ->required(),

                Select::make('post_status')
                    ->label(__('Статус'))
                    ->options(PostStatus::class)
                    ->required(),
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

                ImageColumn::make('group.cover_image')
                    ->label(__('Обкладинка групи'))
                    ->getStateUsing(fn ($record) => $record->group ? $record->group->getFirstMediaUrl('cover_image') : null)
                    ->circular()
                    ->defaultImageUrl(url('path/to/default-group-image.jpg')),

                TextColumn::make('group.name')
                    ->label(__('Група'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->group ? route('filament.admin.resources.groups.view', $record->group_id) : null),

                TextColumn::make('user.username')
                    ->label(__('Користувач'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->user ? route('filament.admin.resources.users.view', $record->user_id) : null),

                TextColumn::make('content')
                    ->label(__('Контент'))
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->content)
                    ->searchable()
                    ->sortable(),

                IconColumn::make('is_pinned')
                    ->label(__('Закріплено'))
                    ->boolean()
                    ->trueIcon('heroicon-o-pin')
                    ->falseIcon('heroicon-o-x-mark')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('category')
                    ->label(__('Категорія'))
                    ->badge()
                    ->formatStateUsing(fn (?PostCategory $state) => $state?->getLabel())
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('post_status')
                    ->label(__('Статус'))
                    ->badge()
                    ->formatStateUsing(fn (?PostStatus $state) => $state?->getLabel())
                    ->sortable()
                    ->toggleable(),

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

                TextColumn::make('moderation_logs_count')
                    ->label(__('Кількість логів модерації'))
                    ->counts('moderationLogs')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('Дата створення'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label(__('Дата оновлення'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('group_id')
                    ->label(__('Група'))
                    ->relationship('group', 'name')
                    ->multiple()
                    ->indicator(__('Група')),

                SelectFilter::make('user_id')
                    ->label(__('Користувач'))
                    ->relationship('user', 'username')
                    ->multiple()
                    ->indicator(__('Користувач')),

                TernaryFilter::make('is_pinned')
                    ->label(__('Закріплено'))
                    ->placeholder(__('Всі'))
                    ->trueLabel(__('Закріплені'))
                    ->falseLabel(__('Незакріплені'))
                    ->indicator(__('Закріплено')),

                SelectFilter::make('category')
                    ->label(__('Категорія'))
                    ->options(PostCategory::class)
                    ->multiple()
                    ->indicator(__('Категорія')),

                SelectFilter::make('post_status')
                    ->label(__('Статус'))
                    ->options(PostStatus::class)
                    ->multiple()
                    ->indicator(__('Статус')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->groups([
                'group_id',
                'user_id',
                'category',
                'post_status',
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CommentsRelationManager::class,
            LikesRelationManager::class,
            FavoritesRelationManager::class,
            GroupModerationLogsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGroupPosts::route('/'),
            'create' => CreateGroupPost::route('/create'),
            'view' => ViewGroupPost::route('/{record}'),
            'edit' => EditGroupPost::route('/{record}/edit'),
        ];
    }
}
