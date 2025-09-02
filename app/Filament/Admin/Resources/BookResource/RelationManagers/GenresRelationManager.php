<?php

namespace App\Filament\Admin\Resources\BookResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class GenresRelationManager extends RelationManager
{
    protected static string $relationship = 'genres';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Жанри книги') . ' ' . $ownerRecord->title;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('Назва жанру'))
                    ->required()
                    ->maxLength(100),

                Select::make('parent_id')
                    ->label(__('Батьківський жанр'))
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                Textarea::make('description')
                    ->label(__('Опис'))
                    ->maxLength(65535)
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Назва'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.admin.resources.genres.view', $record->id)),

                TextColumn::make('parent.name')
                    ->label(__('Батьківський жанр'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('book_count')
                    ->label(__('Кількість книг'))
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
                SelectFilter::make('parent_id')
                    ->label(__('Батьківський жанр'))
                    ->relationship('parent', 'name')
                    ->multiple()
                    ->indicator(__('Батьківський жанр')),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label(__('Додати жанр'))
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(__('Редагувати')),
                Tables\Actions\DetachAction::make()
                    ->label(__('Від’єднати')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->label(__('Від’єднати вибрані')),
                ]),
            ])
            ->defaultSort('name', 'asc');
    }
}
