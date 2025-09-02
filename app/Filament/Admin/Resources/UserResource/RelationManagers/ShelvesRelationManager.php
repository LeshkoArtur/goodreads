<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class ShelvesRelationManager extends RelationManager
{
    protected static string $relationship = 'shelves';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Полиці користувача') . ' ' . $ownerRecord->username;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('Назва полиці'))
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Назва полиці'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('userBooks_count')
                    ->label(__('Кількість книг'))
                    ->counts('userBooks')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(__('Дата створення'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label(__('Дата оновлення'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('has_books')
                    ->label(__('Має книги'))
                    ->query(fn ($query) => $query->has('userBooks'))
                    ->toggleable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('Додати полицю')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(__('Редагувати')),
                Tables\Actions\DeleteAction::make()
                    ->label(__('Видалити')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label(__('Видалити вибрані')),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
