<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use App\Models\Book;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $recordTitleAttribute = 'content';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Коментарі користувача') . ' ' . $ownerRecord->username;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make(__('Об’єкт коментаря'))
                    ->schema([
                        Select::make('commentable_type')
                            ->label(__('Тип об’єкта'))
                            ->options([
                                Book::class => __('Книга'),
                                Post::class => __('Публікація'),
                            ])
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('commentable_id', null)),

                        Select::make('commentable_id')
                            ->label(__('Об’єкт'))
                            ->options(function (callable $get) {
                                $type = $get('commentable_type');
                                if (!$type) {
                                    return [];
                                }
                                return $type::pluck('title', 'id')->toArray();
                            })
                            ->required()
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(2),

                Section::make(__('Коментар'))
                    ->schema([
                        Select::make('parent_id')
                            ->label(__('Батьківський коментар'))
                            ->relationship('parent', 'content', fn ($query) => $query->where('user_id', $this->ownerRecord->id))
                            ->nullable()
                            ->searchable()
                            ->preload(),

                        Textarea::make('content')
                            ->label(__('Коментар'))
                            ->required()
                            ->maxLength(65535)
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('content')
                    ->label(__('Коментар'))
                    ->limit(100)
                    ->tooltip(fn (Model $record): string => $record->content)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('commentable_type')
                    ->label(__('Тип об’єкта'))
                    ->formatStateUsing(fn (string $state): string => __($state === Book::class ? 'Книга' : 'Публікація'))
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('commentable.title')
                    ->label(__('Об’єкт'))
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn (Model $record): string => $record->commentable ? $record->commentable->title : '-')
                    ->url(fn (Model $record): ?string => $record->commentable ? route('filament.admin.resources.' . strtolower(class_basename($record->commentable_type)) . 's.view', $record->commentable_id) : null)
                    ->toggleable(),

                TextColumn::make('parent.content')
                    ->label(__('Батьківський коментар'))
                    ->limit(50)
                    ->tooltip(fn (?Model $record): ?string => $record->parent ? $record->parent->content : null)
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('replies_count')
                    ->label(__('Відповідей'))
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
                Tables\Filters\SelectFilter::make('commentable_type')
                    ->label(__('Тип об’єкта'))
                    ->options([
                        Book::class => __('Книга'),
                        Post::class => __('Публікація'),
                    ])
                    ->multiple()
                    ->indicator(__('Тип об’єкта')),

                Tables\Filters\Filter::make('has_replies')
                    ->label(__('Має відповіді'))
                    ->query(fn ($query) => $query->has('replies'))
                    ->toggleable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('Додати коментар')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(__('Редагувати')),
                Tables\Actions\DeleteAction::make()
                    ->label(__('Видалити')),
                Action::make('view_replies')
                    ->label(__('Переглянути відповіді'))
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->action(fn (Model $record) => redirect()->route('filament.admin.resources.comments.index', ['tableFilters' => ['parent_id' => ['value' => $record->id]]]))
                    ->hidden(fn (Model $record): bool => $record->replies_count === 0),
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
