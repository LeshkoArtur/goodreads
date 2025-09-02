<?php

namespace App\Filament\Admin\Resources\ShelfResource\RelationManagers;

use App\Enums\ReadingFormat;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
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

class UserBooksRelationManager extends RelationManager
{
    protected static string $relationship = 'userBooks';

    protected static ?string $recordTitleAttribute = 'book.title';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Книги в полиці') . ' ' . $ownerRecord->name;
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
                    ->required()
                    ->searchable()
                    ->preload(),

                DatePicker::make('start_date')
                    ->label(__('Дата початку'))
                    ->nullable()
                    ->maxDate(now()),

                DatePicker::make('read_date')
                    ->label(__('Дата прочитання'))
                    ->nullable()
                    ->maxDate(now()),

                TextInput::make('progress_pages')
                    ->label(__('Прогрес (сторінки)'))
                    ->numeric()
                    ->minValue(0)
                    ->nullable(),

                Toggle::make('is_private')
                    ->label(__('Приватна'))
                    ->default(false),

                TextInput::make('rating')
                    ->label(__('Рейтинг'))
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(5)
                    ->nullable(),

                Textarea::make('notes')
                    ->label(__('Нотатки'))
                    ->maxLength(65535)
                    ->nullable()
                    ->columnSpanFull(),

                Select::make('reading_format')
                    ->label(__('Формат читання'))
                    ->options(ReadingFormat::class)
                    ->nullable(),
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

                TextColumn::make('book.title')
                    ->label(__('Книга'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->book ? route('filament.admin.resources.books.view', $record->book_id) : null),

                TextColumn::make('user.username')
                    ->label(__('Користувач'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->user ? route('filament.admin.resources.users.view', $record->user_id) : null),

                TextColumn::make('start_date')
                    ->label(__('Дата початку'))
                    ->date()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('read_date')
                    ->label(__('Дата прочитання'))
                    ->date()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('progress_pages')
                    ->label(__('Прогрес (сторінки)'))
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('is_private')
                    ->label(__('Приватність'))
                    ->boolean()
                    ->trueIcon('heroicon-o-lock-closed')
                    ->falseIcon('heroicon-o-lock-open')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('rating')
                    ->label(__('Рейтинг'))
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        1, 2 => 'danger',
                        3 => 'warning',
                        4, 5 => 'success',
                        default => 'gray',
                    })
                    ->toggleable(),

                TextColumn::make('reading_format')
                    ->label(__('Формат читання'))
                    ->badge()
                    ->formatStateUsing(fn (?ReadingFormat $state) => $state?->getLabel())
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('Дата створення'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

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

                SelectFilter::make('book_id')
                    ->label(__('Книга'))
                    ->relationship('book', 'title')
                    ->multiple()
                    ->indicator(__('Книга')),

                SelectFilter::make('reading_format')
                    ->label(__('Формат читання'))
                    ->options(ReadingFormat::class)
                    ->multiple()
                    ->indicator(__('Формат читання')),

                TernaryFilter::make('is_private')
                    ->label(__('Приватність'))
                    ->placeholder(__('Всі'))
                    ->trueLabel(__('Приватні'))
                    ->falseLabel(__('Публічні'))
                    ->indicator(__('Приватність')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('Додати книгу')),
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
