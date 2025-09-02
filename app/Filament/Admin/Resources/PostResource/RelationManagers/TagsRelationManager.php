<?php

namespace App\Filament\Admin\Resources\PostResource\RelationManagers;

use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TagsRelationManager extends RelationManager
{
    protected static string $relationship = 'tags';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Теги до публікації') . ' ' . \Str::limit($ownerRecord->title, 50);
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make(__('Тег'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Назва'))
                            ->required()
                            ->maxLength(255)
                            ->unique('tags', 'name', ignoreRecord: true),
                    ]),
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
                    ->badge(),
                TextColumn::make('posts_count')
                    ->label(__('Кількість публікацій'))
                    ->counts('posts')
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
                SelectFilter::make('name')
                    ->label(__('Назва'))
                    ->relationship('posts', 'title')
                    ->searchable()
                    ->multiple()
                    ->indicator(__('Назва')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('Додати тег')),
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
