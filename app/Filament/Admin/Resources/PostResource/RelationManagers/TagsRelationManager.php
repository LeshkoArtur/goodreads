<?php

namespace App\Filament\Admin\Resources\PostResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TagsRelationManager extends RelationManager
{
    protected static string $relationship = 'tags';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Теги';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Назва тегу')
                    ->required()
                    ->maxLength(50),
                Forms\Components\Textarea::make('description')
                    ->label('Опис')
                    ->rows(2)
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Тег')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Опис')
                    ->limit(80)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('posts_count')
                    ->label('Використань')
                    ->counts('posts')
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Додати тег')
                    ->preloadRecordSelect()
                    ->multiple()
                    ->modalHeading('Додати теги до поста'),
                Tables\Actions\CreateAction::make()
                    ->label('Створити тег')
                    ->modalHeading('Створити новий тег'),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()->label('Видалити')->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()->label('Видалити обрані')->requiresConfirmation(),
                ]),
            ])
            ->emptyStateHeading('Немає тегів')
            ->emptyStateDescription('Додайте теги до цього поста.')
            ->emptyStateActions([
                Tables\Actions\AttachAction::make()->label('Додати тег')->preloadRecordSelect()->multiple(),
            ]);
    }
}
