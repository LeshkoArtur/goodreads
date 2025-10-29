<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\NoteResource\Pages;
use App\Models\Note;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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

class NoteResource extends Resource
{
    protected static ?string $model = Note::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $navigationGroup = 'Взаємодія користувача';

    protected static ?int $navigationSort = 17;

    public static function getModelLabel(): string
    {
        return 'Нотатка';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Нотатки';
    }

    public static function getNavigationLabel(): string
    {
        return 'Нотатки';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'book']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Нотатка')
                    ->description('Особиста нотатка користувача про книгу')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'username')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Користувач')
                            ->helperText('Автор нотатки'),
                        Select::make('book_id')
                            ->relationship('book', 'title')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Книга')
                            ->helperText('Книга, до якої відноситься нотатка'),
                        TextInput::make('page_number')
                            ->numeric()
                            ->label('Номер сторінки')
                            ->helperText('Опціонально'),
                        RichEditor::make('text')
                            ->required()
                            ->columnSpanFull()
                            ->label('Текст нотатки')
                            ->helperText('Особисті думки та спостереження'),
                        Toggle::make('contains_spoilers')
                            ->required()
                            ->default(false)
                            ->label('Містить спойлери'),
                        Toggle::make('is_private')
                            ->required()
                            ->default(true)
                            ->label('Приватна'),
                    ])
                    ->columns(3),
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
                    ->sortable(),
                TextColumn::make('text')
                    ->label('Текст')
                    ->limit(50)
                    ->wrap(),
                IconColumn::make('is_private')
                    ->label('Приватна')
                    ->boolean(),
                IconColumn::make('contains_spoilers')
                    ->label('Спойлери')
                    ->boolean(),
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
                SelectFilter::make('user')
                    ->relationship('user', 'username')
                    ->label('Користувач')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                SelectFilter::make('book')
                    ->relationship('book', 'title')
                    ->label('Книга')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                TernaryFilter::make('is_private')
                    ->label('Приватна'),
                TernaryFilter::make('contains_spoilers')
                    ->label('Містить спойлери'),
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
            'index' => Pages\ListNotes::route('/'),
            'create' => Pages\CreateNote::route('/create'),
            'view' => Pages\ViewNote::route('/{record}'),
            'edit' => Pages\EditNote::route('/{record}/edit'),
        ];
    }
}
