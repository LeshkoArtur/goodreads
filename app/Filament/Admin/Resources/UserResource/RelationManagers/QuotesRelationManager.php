<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class QuotesRelationManager extends RelationManager
{
    protected static string $relationship = 'quotes';

    protected static ?string $recordTitleAttribute = 'text';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Цитати користувача') . ' ' . $ownerRecord->username;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('book_id')
                    ->label(__('Книга'))
                    ->relationship('book', 'title')
                    ->required()
                    ->searchable()
                    ->preload(),
                Textarea::make('text')
                    ->label(__('Текст цитати'))
                    ->required()
                    ->maxLength(65535)
                    ->rows(5)
                    ->columnSpanFull(),
                TextInput::make('page_number')
                    ->label(__('Номер сторінки'))
                    ->numeric()
                    ->minValue(1),
                Toggle::make('contains_spoilers')
                    ->label(__('Містить спойлери'))
                    ->default(false),
                Toggle::make('is_public')
                    ->label(__('Публічна цитата'))
                    ->default(true),
            ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('book.title')
                    ->label(__('Книга'))
                    ->searchable()
                    ->sortable()
                    ->url(fn (Model $record): ?string => $record->book ? route('filament.admin.resources.books.view', $record->book_id) : null),
                TextColumn::make('text')
                    ->label(__('Текст цитати'))
                    ->limit(100)
                    ->tooltip(fn (Model $record): string => $record->text)
                    ->searchable(),
                TextColumn::make('page_number')
                    ->label(__('Сторінка'))
                    ->sortable(),
                BooleanColumn::make('contains_spoilers')
                    ->label(__('Спойлери'))
                    ->toggleable(),
                BooleanColumn::make('is_public')
                    ->label(__('Публічна'))
                    ->toggleable(),
                TextColumn::make('comments_count')
                    ->label(__('Коментарі'))
                    ->counts('comments')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('likes_count')
                    ->label(__('Лайки'))
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
                Tables\Filters\TernaryFilter::make('is_public')
                    ->label(__('Публічність'))
                    ->placeholder(__('Всі'))
                    ->trueLabel(__('Публічні'))
                    ->falseLabel(__('Приватні'))
                    ->indicator(__('Публічність')),
                Tables\Filters\SelectFilter::make('book_id')
                    ->label(__('Книга'))
                    ->relationship('book', 'title')
                    ->multiple()
                    ->indicator(__('Книга')),
                Tables\Filters\Filter::make('has_comments')
                    ->label(__('Має коментарі'))
                    ->query(fn ($query) => $query->has('comments'))
                    ->toggleable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('Додати цитату')),
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
