<?php

namespace App\Filament\Admin\Resources\BookResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class QuotesRelationManager extends RelationManager
{
    protected static string $relationship = 'quotes';

    protected static ?string $recordTitleAttribute = 'text';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Цитати книги') . ' ' . $ownerRecord->title;
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

                Textarea::make('text')
                    ->label(__('Текст цитати'))
                    ->required()
                    ->maxLength(65535)
                    ->rows(5)
                    ->columnSpanFull(),

                TextInput::make('page_number')
                    ->label(__('Номер сторінки'))
                    ->numeric()
                    ->minValue(1)
                    ->nullable(),

                Toggle::make('contains_spoilers')
                    ->label(__('Містить спойлери'))
                    ->default(false),

                Toggle::make('is_public')
                    ->label(__('Публічна цитата'))
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('book.cover_image')
                    ->label(__('Обкладинка'))
                    ->getStateUsing(fn ($record) => $record->book ? $record->book->getFirstMediaUrl('cover_image') : null)
                    ->circular()
                    ->defaultImageUrl(url('path/to/default-book-image.jpg')),

                TextColumn::make('user.username')
                    ->label(__('Користувач'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->user ? route('filament.admin.resources.users.view', $record->user_id) : null),

                TextColumn::make('text')
                    ->label(__('Текст цитати'))
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->text)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('page_number')
                    ->label(__('Сторінка'))
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('contains_spoilers')
                    ->label(__('Спойлери'))
                    ->boolean()
                    ->trueIcon('heroicon-o-exclamation-circle')
                    ->falseIcon('heroicon-o-check-circle')
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('is_public')
                    ->label(__('Публічність'))
                    ->boolean()
                    ->trueIcon('heroicon-o-lock-open')
                    ->falseIcon('heroicon-o-lock-closed')
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
                SelectFilter::make('user_id')
                    ->label(__('Користувач'))
                    ->relationship('user', 'username')
                    ->multiple()
                    ->indicator(__('Користувач')),

                TernaryFilter::make('contains_spoilers')
                    ->label(__('Спойлери'))
                    ->placeholder(__('Всі'))
                    ->trueLabel(__('Містять спойлери'))
                    ->falseLabel(__('Без спойлерів'))
                    ->indicator(__('Спойлери')),

                TernaryFilter::make('is_public')
                    ->label(__('Публічність'))
                    ->placeholder(__('Всі'))
                    ->trueLabel(__('Публічні'))
                    ->falseLabel(__('Приватні'))
                    ->indicator(__('Публічність')),
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
