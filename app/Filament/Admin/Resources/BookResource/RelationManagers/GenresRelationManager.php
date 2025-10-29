<?php

namespace App\Filament\Admin\Resources\BookResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class GenresRelationManager extends RelationManager
{
    protected static string $relationship = 'genres';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Жанри';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Назва жанру')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('Опис')
                    ->rows(3)
                    ->maxLength(1000),
                Forms\Components\Select::make('parent_id')
                    ->label('Батьківський жанр')
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->preload()
                    ->helperText('Залиште порожнім для головного жанру'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Назва')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Батьківський жанр')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('gray')
                    ->placeholder('—')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Опис')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('books_count')
                    ->label('Книг')
                    ->counts('books')
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('parent_id')
                    ->label('Тип жанру')
                    ->placeholder('Всі жанри')
                    ->trueLabel('Підкатегорії')
                    ->falseLabel('Головні жанри')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('parent_id'),
                        false: fn ($query) => $query->whereNull('parent_id'),
                    ),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Прикріпити жанр')
                    ->preloadRecordSelect()
                    ->multiple()
                    ->recordSelectSearchColumns(['name', 'description'])
                    ->modalHeading('Прикріпити жанри до книги'),
                Tables\Actions\CreateAction::make()
                    ->label('Створити жанр')
                    ->modalHeading('Створити новий жанр'),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()
                    ->label('Відкріпити')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->label('Відкріпити обрані')
                        ->requiresConfirmation(),
                ]),
            ])
            ->emptyStateHeading('Немає жанрів')
            ->emptyStateDescription('Додайте жанри до цієї книги.')
            ->emptyStateActions([
                Tables\Actions\AttachAction::make()
                    ->label('Прикріпити жанр')
                    ->preloadRecordSelect()
                    ->multiple(),
            ]);
    }
}
