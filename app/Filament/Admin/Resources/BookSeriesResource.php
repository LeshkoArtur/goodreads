<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BookSeriesResource\Pages;
use App\Models\BookSeries;
use Filament\Forms\Components\Section;
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
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BookSeriesResource extends Resource
{
    protected static ?string $model = BookSeries::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Деталізація книги';

    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getModelLabel(): string
    {
        return 'Серія книг';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Серії книг';
    }

    public static function getNavigationLabel(): string
    {
        return 'Серії';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'description'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->title;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Книг' => $record->books_count ?? 0,
            'Статус' => $record->is_completed ? 'Завершена' : 'Продовжується',
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount(['books']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основна інформація')
                    ->description('Інформація про серію книг')
                    ->schema([
                        TextInput::make('title')
                            ->label('Назва серії')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Повна назва серії книг'),
                        TextInput::make('total_books')
                            ->label('Загальна кількість книг')
                            ->numeric()
                            ->minValue(1)
                            ->helperText('Скільки книг планується в серії (якщо відомо)'),
                        Toggle::make('is_completed')
                            ->label('Серія завершена')
                            ->default(false)
                            ->helperText('Чи всі книги серії вже опубліковані'),
                        Textarea::make('description')
                            ->label('Опис серії')
                            ->rows(5)
                            ->maxLength(2000)
                            ->helperText('Загальний опис та ідея серії (до 2000 символів)')
                            ->columnSpanFull(),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Назва серії')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(50)
                    ->tooltip(fn (BookSeries $record): ?string => $record->title),
                TextColumn::make('books_count')
                    ->label('Книг у серії')
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total_books')
                    ->label('Всього планується')
                    ->sortable()
                    ->searchable()
                    ->placeholder('—')
                    ->toggleable(),
                IconColumn::make('is_completed')
                    ->label('Завершена')
                    ->boolean()
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
                TernaryFilter::make('is_completed')
                    ->label('Завершена серія'),
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
            ->defaultSort('books_count', 'desc')
            ->striped()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();
    }

    public static function getRelations(): array
    {
        return [
            BookSeriesResource\RelationManagers\BooksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookSeries::route('/'),
            'create' => Pages\CreateBookSeries::route('/create'),
            'view' => Pages\ViewBookSeries::route('/{record}'),
            'edit' => Pages\EditBookSeries::route('/{record}/edit'),
        ];
    }
}
