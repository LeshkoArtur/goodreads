<?php

namespace App\Filament\Admin\Resources\TagResource\RelationManagers;

use App\Enums\PostStatus;
use App\Enums\PostType;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    protected static ?string $recordTitleAttribute = 'title';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Публікації з тегом') . ' ' . $ownerRecord->name;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label(__('Користувач'))
                    ->relationship('user', 'username')
                    ->required()
                    ->searchable()
                    ->preload(),

                Select::make('book_id')
                    ->label(__('Книга'))
                    ->relationship('book', 'title')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                Select::make('author_id')
                    ->label(__('Автор'))
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                TextInput::make('title')
                    ->label(__('Заголовок'))
                    ->required()
                    ->maxLength(255),

                Textarea::make('content')
                    ->label(__('Контент'))
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('cover_image')
                    ->label(__('Обкладинка'))
                    ->directory('cover_image')
                    ->image()
                    ->maxSize(2048)
                    ->nullable(),

                DateTimePicker::make('published_at')
                    ->label(__('Дата публікації'))
                    ->nullable(),

                Select::make('type')
                    ->label(__('Тип публікації'))
                    ->options(PostType::class)
                    ->required(),

                Select::make('status')
                    ->label(__('Статус'))
                    ->options(PostStatus::class)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->label(__('Обкладинка'))
                    ->getStateUsing(fn ($record) => $record->getFirstMediaUrl('cover_image'))
                    ->circular()
                    ->defaultImageUrl(url('path/to/default-post-image.jpg')),

                TextColumn::make('title')
                    ->label(__('Заголовок'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.admin.resources.posts.view', $record->id)),

                TextColumn::make('user.username')
                    ->label(__('Користувач'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->user ? route('filament.admin.resources.users.view', $record->user_id) : null),

                TextColumn::make('book.title')
                    ->label(__('Книга'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->book ? route('filament.admin.resources.books.view', $record->book_id) : null)
                    ->toggleable(),

                TextColumn::make('author.name')
                    ->label(__('Автор'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->author ? route('filament.admin.resources.authors.view', $record->author_id) : null)
                    ->toggleable(),

                TextColumn::make('type')
                    ->label(__('Тип публікації'))
                    ->badge()
                    ->formatStateUsing(fn (?PostType $state) => $state?->getLabel())
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label(__('Статус'))
                    ->badge()
                    ->formatStateUsing(fn (?PostStatus $state) => $state?->getLabel())
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('published_at')
                    ->label(__('Дата публікації'))
                    ->dateTime()
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
                SelectFilter::make('type')
                    ->label(__('Тип публікації'))
                    ->options(PostType::class)
                    ->multiple()
                    ->indicator(__('Тип публікації')),

                SelectFilter::make('status')
                    ->label(__('Статус'))
                    ->options(PostStatus::class)
                    ->multiple()
                    ->indicator(__('Статус')),

                SelectFilter::make('user_id')
                    ->label(__('Користувач'))
                    ->relationship('user', 'username')
                    ->multiple()
                    ->indicator(__('Користувач')),

                SelectFilter::make('book_id')
                    ->label(__('Книга'))
                    ->relationship('book', 'title')
                    ->multiple()
                    ->indicator(__('Книга')),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label(__('Додати публікацію'))
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(__('Редагувати')),
                Tables\Actions\DetachAction::make()
                    ->label(__('Від’єднати')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->label(__('Від’єднати вибрані')),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
