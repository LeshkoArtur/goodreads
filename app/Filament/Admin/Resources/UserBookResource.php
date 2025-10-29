<?php

namespace App\Filament\Admin\Resources;

use App\Enums\ReadingFormat;
use App\Filament\Admin\Resources\UserBookResource\Pages;
use App\Models\UserBook;
use Filament\Forms\Components\DatePicker;
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

class UserBookResource extends Resource
{
    protected static ?string $model = UserBook::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    protected static ?string $navigationGroup = 'Взаємодія користувача';

    protected static ?int $navigationSort = 11;

    public static function getModelLabel(): string
    {
        return 'Книга користувача';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Книги користувачів';
    }

    public static function getNavigationLabel(): string
    {
        return 'Книги користувачів';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основна інформація')
                    ->description('Книга користувача та її полиця')
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
                        Select::make('shelf_id')
                            ->label('Полиця')
                            ->relationship('shelf', 'name')
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(3),

                Section::make('Прогрес читання')
                    ->description('Інформація про прогрес читання книги')
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Дата початку')
                            ->native(false),
                        DatePicker::make('read_date')
                            ->label('Дата прочитання')
                            ->native(false),
                        TextInput::make('progress_pages')
                            ->label('Прогрес (сторінок)')
                            ->numeric()
                            ->minValue(0),
                        Select::make('reading_format')
                            ->label('Формат читання')
                            ->options(ReadingFormat::class)
                            ->native(false),
                        Select::make('rating')
                            ->label('Оцінка')
                            ->options([
                                1 => '1 ⭐',
                                2 => '2 ⭐⭐',
                                3 => '3 ⭐⭐⭐',
                                4 => '4 ⭐⭐⭐⭐',
                                5 => '5 ⭐⭐⭐⭐⭐',
                            ])
                            ->native(false),
                        Toggle::make('is_private')
                            ->label('Приватна')
                            ->default(false),
                    ])
                    ->columns(3),

                Section::make('Нотатки')
                    ->description('Особисті нотатки про книгу')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Нотатки')
                            ->rows(5)
                            ->maxLength(2000)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.username')
                    ->label('Користувач')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('book.title')
                    ->label('Книга')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                TextColumn::make('shelf.name')
                    ->label('Полиця')
                    ->badge()
                    ->color('info'),
                TextColumn::make('reading_format')
                    ->label('Формат')
                    ->badge()
                    ->color(fn (?ReadingFormat $state): string|array|null => $state?->getColor()),
                TextColumn::make('progress_pages')
                    ->label('Прогрес')
                    ->sortable(),
                TextColumn::make('rating')
                    ->label('Оцінка')
                    ->badge()
                    ->color(fn ($state) => $state >= 4 ? 'success' : ($state >= 3 ? 'warning' : 'danger'))
                    ->formatStateUsing(fn ($state) => $state ? $state.' ⭐' : '—'),
                IconColumn::make('is_private')
                    ->label('Приватна')
                    ->boolean(),
                TextColumn::make('start_date')
                    ->label('Початок')
                    ->date('d.m.Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('read_date')
                    ->label('Прочитано')
                    ->date('d.m.Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('Оновлено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user')
                    ->label('Користувач')
                    ->relationship('user', 'username')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                SelectFilter::make('shelf')
                    ->label('Полиця')
                    ->relationship('shelf', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                SelectFilter::make('reading_format')
                    ->label('Формат')
                    ->options(ReadingFormat::class)
                    ->native(false),
                TernaryFilter::make('is_private')
                    ->label('Приватна'),
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
            ->striped();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserBooks::route('/'),
            'create' => Pages\CreateUserBook::route('/create'),
            'edit' => Pages\EditUserBook::route('/{record}/edit'),
        ];
    }
}
