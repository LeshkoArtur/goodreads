<?php

namespace App\Filament\Admin\Resources\GroupResource\RelationManagers;

use App\Enums\PostCategory;
use App\Enums\PostStatus;
use App\Models\Group;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class GroupPostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    protected static ?string $recordTitleAttribute = 'content';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Публікації групи') . ' ' . $ownerRecord->name;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make(__('Публікація'))
                    ->schema([
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
                            ->rows(5)
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
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.username')
                    ->label(__('Користувач'))
                    ->searchable()
                    ->sortable()
                    ->url(fn (Model $record): ?string => $record->user ? route('filament.resources.users.view', $record->user_id) : null),
                TextColumn::make('content')
                    ->label(__('Контент'))
                    ->limit(50)
                    ->tooltip(fn (Model $record): string => $record->content)
                    ->searchable()
                    ->sortable()
                    ->url(fn (Model $record): string => route('filament.resources.group-posts.view', $record->id)),
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
                SelectFilter::make('user')
                    ->label(__('Користувач'))
                    ->relationship('user', 'username')
                    ->searchable()
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
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('Додати публікацію')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(__('Редагувати')),
                Tables\Actions\DeleteAction::make()
                    ->label(__('Видалити')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label(__('Видалити вибрані')),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
