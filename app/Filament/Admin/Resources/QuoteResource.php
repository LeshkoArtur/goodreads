<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\QuoteResource\Pages;
use App\Models\Quote;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class QuoteResource extends Resource
{
    protected static ?string $model = Quote::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Деталізація книги';

    protected static ?int $navigationSort = 8;

    public static function getModelLabel(): string
    {
        return 'Цитата';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Цитати';
    }

    public static function getNavigationLabel(): string
    {
        return 'Цитати';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['text', 'user.username', 'book.title'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return substr($record->text, 0, 60).'...';
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Книга' => $record->book->title,
            'Користувач' => $record->user->username,
            'Сторінка' => $record->page_number ?: '—',
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount(['comments', 'likes']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основна інформація')
                    ->description('Інформація про автора та книгу')
                    ->schema([
                        Select::make('user_id')
                            ->label('Користувач')
                            ->relationship('user', 'username')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Select::make('book_id')
                            ->label('Книга')
                            ->relationship('book', 'title')
                            ->required()
                            ->searchable()
                            ->preload(),
                        TextInput::make('page_number')
                            ->label('Номер сторінки')
                            ->numeric()
                            ->minValue(1),
                    ])
                    ->columns(3),

                Section::make('Текст цитати')
                    ->description('Зміст цитати')
                    ->schema([
                        Textarea::make('text')
                            ->label('Цитата')
                            ->required()
                            ->rows(5)
                            ->maxLength(2000)
                            ->columnSpanFull(),
                    ]),

                Section::make('Налаштування')
                    ->description('Параметри видимості')
                    ->schema([
                        Toggle::make('is_public')
                            ->label('Публічна')
                            ->default(true)
                            ->helperText('Чи може ця цитата бути видима іншим користувачам'),
                        Toggle::make('contains_spoilers')
                            ->label('Містить спойлери')
                            ->default(false)
                            ->helperText('Позначте, якщо цитата розкриває сюжет'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('text')
                    ->label('Цитата')
                    ->searchable()
                    ->limit(80)
                    ->wrap()
                    ->weight('medium'),
                TextColumn::make('user.username')
                    ->label('Користувач')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('book.title')
                    ->label('Книга')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->toggleable(),
                TextColumn::make('page_number')
                    ->label('Стор.')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(),
                IconColumn::make('is_public')
                    ->label('Публічна')
                    ->boolean()
                    ->toggleable(),
                IconColumn::make('contains_spoilers')
                    ->label('Спойлер')
                    ->boolean()
                    ->toggleable(),
                TextColumn::make('comments_count')
                    ->label('Коментарів')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('likes_count')
                    ->label('Лайків')
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Оновлено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_public')
                    ->label('Публічна'),
                TernaryFilter::make('contains_spoilers')
                    ->label('Містить спойлери'),
                SelectFilter::make('user')
                    ->label('Користувач')
                    ->relationship('user', 'username')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('book')
                    ->label('Книга')
                    ->relationship('book', 'title')
                    ->searchable()
                    ->preload()
                    ->multiple(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();
    }

    public static function getRelations(): array
    {
        return [
            QuoteResource\RelationManagers\CommentsRelationManager::class,
            QuoteResource\RelationManagers\LikesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuotes::route('/'),
            'create' => Pages\CreateQuote::route('/create'),
            'view' => Pages\ViewQuote::route('/{record}'),
            'edit' => Pages\EditQuote::route('/{record}/edit'),
        ];
    }
}
