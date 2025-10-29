<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ReadingStatResource\Pages;
use App\Models\ReadingStat;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReadingStatResource extends Resource
{
    protected static ?string $model = ReadingStat::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Взаємодія користувача';

    protected static ?int $navigationSort = 18;

    public static function getModelLabel(): string
    {
        return 'Статистика читання';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Статистика читання';
    }

    public static function getNavigationLabel(): string
    {
        return 'Статистика читання';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Статистика читання')
                    ->description('Річна статистика користувача')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'username')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Користувач'),
                        TextInput::make('year')
                            ->required()
                            ->numeric()
                            ->label('Рік'),
                        TextInput::make('books_read')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->label('Прочитано книг'),
                        TextInput::make('pages_read')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->label('Прочитано сторінок'),
                        KeyValue::make('genres_read')
                            ->label('Прочитані жанри')
                            ->keyLabel('Жанр')
                            ->valueLabel('Кількість'),
                    ])
                    ->columns(2),
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
                TextColumn::make('year')
                    ->label('Рік')
                    ->sortable(),
                TextColumn::make('books_read')
                    ->label('Прочитано книг')
                    ->sortable(),
                TextColumn::make('pages_read')
                    ->label('Прочитано сторінок')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user')
                    ->relationship('user', 'username')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->label('Користувач'),
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
            ->defaultSort('year', 'desc')
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
            'index' => Pages\ListReadingStats::route('/'),
            'create' => Pages\CreateReadingStat::route('/create'),
            'view' => Pages\ViewReadingStat::route('/{record}'),
            'edit' => Pages\EditReadingStat::route('/{record}/edit'),
        ];
    }
}
