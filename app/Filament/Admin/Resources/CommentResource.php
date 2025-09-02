<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CommentResource\Pages\CreateComment;
use App\Filament\Admin\Resources\CommentResource\Pages\EditComment;
use App\Filament\Admin\Resources\CommentResource\Pages\ListComments;
use App\Filament\Admin\Resources\CommentResource\Pages\ViewComment;
use App\Filament\Admin\Resources\CommentResource\RelationManagers\RepliesRelationManager;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left';

    protected static ?string $navigationGroup = 'Коментарі';

    protected static ?int $navigationSort = 8;

    public static function getNavigationLabel(): string
    {
        return __('Коментарі');
    }

    public static function getModelLabel(): string
    {
        return __('Коментар');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Коментарі');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label(__('Користувач'))
                    ->relationship('user', 'username')
                    ->required()
                    ->searchable()
                    ->preload(),

                Select::make('commentable_type')
                    ->label(__('Тип коментованого об’єкта'))
                    ->options([
                        'App\Models\Post' => __('Публікація'),
                        'App\Models\Quote' => __('Цитата'),
                        'App\Models\Rating' => __('Рейтинг'),
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('commentable_id', null)),

                Select::make('commentable_id')
                    ->label(__('Коментований об’єкт'))
                    ->options(function (callable $get) {
                        $type = $get('commentable_type');
                        if ($type === 'App\Models\Post') {
                            return \App\Models\Post::pluck('title', 'id')->toArray();
                        } elseif ($type === 'App\Models\Quote') {
                            return \App\Models\Quote::pluck('text', 'id')->map(fn ($text) => \Str::limit($text, 50))->toArray();
                        } elseif ($type === 'App\Models\Rating') {
                            return \App\Models\Rating::pluck('id', 'id')->toArray();
                        }
                        return [];
                    })
                    ->required()
                    ->searchable()
                    ->preload()
                    ->disabled(fn (callable $get) => ! $get('commentable_type')),

                Select::make('parent_id')
                    ->label(__('Батьківський коментар'))
                    ->relationship('parent', 'content', fn ($query) => $query->where('commentable_type', fn ($get) => $get('commentable_type'))->where('commentable_id', fn ($get) => $get('commentable_id')))
                    ->searchable()
                    ->preload()
                    ->nullable(),

                Textarea::make('content')
                    ->label(__('Контент'))
                    ->required()
                    ->maxLength(65535)
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

                TextColumn::make('user.username')
                    ->label(__('Користувач'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->user ? route('filament.admin.resources.users.view', $record->user_id) : null),

                TextColumn::make('commentable_type')
                    ->label(__('Тип об’єкта'))
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'App\Models\Post' => __('Публікація'),
                        'App\Models\Quote' => __('Цитата'),
                        'App\Models\Rating' => __('Рейтинг'),
                        default => $state ?? '-',
                    })
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('commentable_id')
                    ->label(__('Об’єкт'))
                    ->getStateUsing(function ($record) {
                        if ($record->commentable_type === 'App\Models\Post') {
                            return $record->commentable?->title ?? '-';
                        } elseif ($record->commentable_type === 'App\Models\Quote') {
                            return $record->commentable ? \Str::limit($record->commentable->text, 50) : '-';
                        } elseif ($record->commentable_type === 'App\Models\Rating') {
                            return $record->commentable ? 'Рейтинг #' . $record->commentable_id : '-';
                        }
                        return '-';
                    })
                    ->url(function ($record) {
                        if ($record->commentable_type === 'App\Models\Post') {
                            return $record->commentable ? route('filament.admin.resources.posts.view', $record->commentable_id) : null;
                        } elseif ($record->commentable_type === 'App\Models\Quote') {
                            return $record->commentable ? route('filament.admin.resources.quotes.view', $record->commentable_id) : null;
                        } elseif ($record->commentable_type === 'App\Models\Rating') {
                            return $record->commentable ? route('filament.admin.resources.ratings.view', $record->commentable_id) : null;
                        }
                        return null;
                    })
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('content')
                    ->label(__('Контент'))
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->content)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('parent.content')
                    ->label(__('Батьківський коментар'))
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->parent?->content)
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('replies_count')
                    ->label(__('Кількість відповідей'))
                    ->counts('replies')
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
                SelectFilter::make('commentable_type')
                    ->label(__('Тип об’єкта'))
                    ->options([
                        'App\Models\Post' => __('Публікація'),
                        'App\Models\Quote' => __('Цитата'),
                        'App\Models\Rating' => __('Рейтинг'),
                    ])
                    ->multiple()
                    ->indicator(__('Тип об’єкта')),

                SelectFilter::make('user_id')
                    ->label(__('Користувач'))
                    ->relationship('user', 'username')
                    ->multiple()
                    ->indicator(__('Користувач')),
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
                'commentable_type',
                'user_id',
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListComments::route('/'),
            'create' => CreateComment::route('/create'),
            'view' => ViewComment::route('/{record}'),
            'edit' => EditComment::route('/{record}/edit'),
        ];
    }
}
