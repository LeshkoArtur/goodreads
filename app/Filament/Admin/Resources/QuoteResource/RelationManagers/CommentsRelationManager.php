<?php

namespace App\Filament\Admin\Resources\QuoteResource\RelationManagers;

use App\Models\Quote;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $recordTitleAttribute = 'content';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Коментарі до цитати') . ' ' . \Str::limit($ownerRecord->text, 50);
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make(__('Коментар'))
                    ->schema([
                        Select::make('user_id')
                            ->label(__('Автор'))
                            ->relationship('user', 'username')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('parent_id')
                            ->label(__('Батьківський коментар'))
                            ->relationship('parent', 'content', fn ($query) => $query->where('commentable_type', Quote::class)->where('commentable_id', $this->ownerRecord->id))
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
                TextColumn::make('user.username')
                    ->label(__('Автор'))
                    ->searchable()
                    ->sortable()
                    ->url(fn (Model $record): ?string => $record->user ? route('filament.admin.resources.users.view', $record->user_id) : null),
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
                TextColumn::make('moderation_logs_count')
                    ->label(__('Логів модерації'))
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
                    ->label(__('Автор'))
                    ->relationship('user', 'username')
                    ->searchable()
                    ->multiple()
                    ->indicator(__('Автор')),
                Filter::make('has_replies')
                    ->label(__('Має відповіді'))
                    ->query(fn ($query) => $query->has('replies'))
                    ->toggleable(),
                Filter::make('has_moderation_logs')
                    ->label(__('Має логи модерації'))
                    ->query(fn ($query) => $query->has('moderationLogs'))
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
                Tables\Actions\Action::make('view_replies')
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
