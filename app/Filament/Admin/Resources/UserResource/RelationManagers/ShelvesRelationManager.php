<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ShelvesRelationManager extends RelationManager
{
    protected static string $relationship = 'shelves';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Полиці';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Назва полиці')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('Опис')
                    ->rows(3)
                    ->maxLength(1000),
                Forms\Components\Toggle::make('is_public')
                    ->label('Публічна')
                    ->default(true)
                    ->helperText('Публічні полиці видимі іншим користувачам'),
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
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Опис')
                    ->limit(100)
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_public')
                    ->label('Публічна')
                    ->boolean()
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
                Tables\Filters\TernaryFilter::make('is_public')
                    ->label('Публічність')
                    ->placeholder('Всі полиці')
                    ->trueLabel('Публічні')
                    ->falseLabel('Приватні'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Створити полицю')
                    ->modalHeading('Створити нову полицю'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Редагувати'),
                Tables\Actions\DeleteAction::make()
                    ->label('Видалити')
                    ->requiresConfirmation()
                    ->modalHeading('Видалити полицю?')
                    ->modalDescription('Всі книги на цій полиці будуть відкріплені.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Видалити обрані')
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('name')
            ->emptyStateHeading('Немає полиць')
            ->emptyStateDescription('Створіть першу полицю для організації книг.')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Створити полицю'),
            ]);
    }
}
