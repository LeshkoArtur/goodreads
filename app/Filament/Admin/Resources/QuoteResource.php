<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\QuoteResource\Pages\CreateQuote;
use App\Filament\Admin\Resources\QuoteResource\Pages\EditQuote;
use App\Filament\Admin\Resources\QuoteResource\Pages\ListQuotes;
use App\Filament\Admin\Resources\QuoteResource\Pages\ViewQuote;
use App\Filament\Admin\Resources\QuoteResource\RelationManagers\CommentsRelationManager;
use App\Models\Quote;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class QuoteResource extends Resource
{
    protected static ?string $model = Quote::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    protected static ?string $navigationGroup = 'Цитати';

    protected static ?int $navigationSort = 9;

    public static function getNavigationLabel(): string
    {
        return __('Цитати');
    }

    public static function getModelLabel(): string
    {
        return __('Цитата');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Цитати');
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

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

                TextColumn::make('favorites_count')
                    ->label(__('Кількість у вибране'))
                    ->counts('favorites')
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

                SelectFilter::make('book_id')
                    ->label(__('Книга'))
                    ->relationship('book', 'title')
                    ->multiple()
                    ->indicator(__('Книга')),

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
                'book_id',
                'user_id',
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CommentsRelationManager::class,
        ];

    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuotes::route('/'),
            'create' => CreateQuote::route('/create'),
            'view' => ViewQuote::route('/{record}'),
            'edit' => EditQuote::route('/{record}/edit'),
        ];
    }
}
