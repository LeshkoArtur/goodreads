<?php

namespace App\Filament\Admin\Resources\GenreResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SubgenresRelationManager extends RelationManager
{
    protected static string $relationship = 'subgenres';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Підкатегорії жанру';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Назва підкатегорії')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('Опис')
                    ->rows(3)
                    ->maxLength(1000),
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
                Tables\Columns\TextColumn::make('description')
                    ->label('Опис')
                    ->limit(100)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('books_count')
                    ->label('Книг')
                    ->counts('books')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Створити підкатегорію')
                    ->modalHeading('Створити підкатегорію жанру'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Редагувати'),
                Tables\Actions\DeleteAction::make()->label('Видалити')->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Видалити обрані')->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('name')
            ->emptyStateHeading('Немає підкатегорій')
            ->emptyStateDescription('Створіть підкатегорії для цього жанру.')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()->label('Створити підкатегорію'),
            ]);
    }
}
