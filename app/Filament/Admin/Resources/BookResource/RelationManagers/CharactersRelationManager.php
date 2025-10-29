<?php

namespace App\Filament\Admin\Resources\BookResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CharactersRelationManager extends RelationManager
{
    protected static string $relationship = 'characters';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Персонажі';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Ім\'я персонажа')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->label('Зображення')
                    ->image()
                    ->disk('public')
                    ->directory('characters')
                    ->imageEditor()
                    ->imageCropAspectRatio('2:3'),
                Forms\Components\TextInput::make('role')
                    ->label('Роль')
                    ->maxLength(100)
                    ->helperText('Наприклад: Головний герой, Антагоніст, тощо'),
                Forms\Components\Textarea::make('description')
                    ->label('Опис')
                    ->rows(4)
                    ->maxLength(2000),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Зображення')
                    ->circular()
                    ->size(50),
                Tables\Columns\TextColumn::make('name')
                    ->label('Ім\'я')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('role')
                    ->label('Роль')
                    ->searchable()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Опис')
                    ->limit(100)
                    ->toggleable(),
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
                    ->label('Додати персонажа')
                    ->modalHeading('Додати нового персонажа'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Редагувати'),
                Tables\Actions\DeleteAction::make()
                    ->label('Видалити')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Видалити обрані')
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('name')
            ->emptyStateHeading('Немає персонажів')
            ->emptyStateDescription('Додайте персонажів цієї книги.')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Додати персонажа'),
            ]);
    }
}
