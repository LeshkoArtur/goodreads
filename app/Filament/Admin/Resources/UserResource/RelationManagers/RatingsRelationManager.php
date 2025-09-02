<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class RatingsRelationManager extends RelationManager
{
    protected static string $relationship = 'ratings';

    protected static ?string $recordTitleAttribute = 'rating';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Оцінки користувача') . ' ' . $ownerRecord->username;
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
                TextInput::make('rating')
                    ->label(__('Оцінка'))
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(5),
                Textarea::make('review')
                    ->label(__('Відгук'))
                    ->maxLength(65535)
                    ->rows(5)
                    ->columnSpanFull(),
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
                TextColumn::make('rating')
                    ->label(__('Оцінка'))
                    ->sortable(),
                TextColumn::make('review')
                    ->label(__('Відгук'))
                    ->limit(100)
                    ->tooltip(fn (Model $record): ?string => $record->review ?? '-')
                    ->searchable(),
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
                Tables\Filters\SelectFilter::make('book_id')
                    ->label(__('Книга'))
                    ->relationship('book', 'title')
                    ->multiple()
                    ->indicator(__('Книга')),
                Tables\Filters\Filter::make('has_comments')
                    ->label(__('Має коментарі'))
                    ->query(fn ($query) => $query->has('comments'))
                    ->toggleable(),
                Tables\Filters\SelectFilter::make('rating')
                    ->label(__('Оцінка'))
                    ->options([
                        1 => '1',
                        2 => '2',
                        3 => '3',
                        4 => '4',
                        5 => '5',
                    ])
                    ->multiple()
                    ->indicator(__('Оцінка')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('Додати оцінку')),
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
