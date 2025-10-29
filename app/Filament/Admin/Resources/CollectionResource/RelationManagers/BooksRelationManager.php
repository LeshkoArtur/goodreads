<?php

namespace App\Filament\Admin\Resources\CollectionResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;

class BooksRelationManager extends RelationManager
{
    protected static string $relationship = 'books';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $title = 'Книги колекції';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('order_index')
                    ->label('Порядок')
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Обкладинка')
                    ->size(50),
                Tables\Columns\TextColumn::make('title')
                    ->label('Назва')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('authors.name')
                    ->label('Автори')
                    ->listWithLineBreaks()
                    ->limitList(2),
                Tables\Columns\TextColumn::make('average_rating')
                    ->label('Рейтинг')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 1).' ⭐' : '—'),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Додати книгу')
                    ->preloadRecordSelect()
                    ->multiple()
                    ->modalHeading('Додати книги до колекції')
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\TextInput::make('order_index')
                            ->label('Порядок')
                            ->numeric()
                            ->default(fn () => \App\Models\Collection::find($this->ownerRecord->id)->books()->max('order_index') + 1)
                            ->required(),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Змінити порядок')
                    ->form([
                        Forms\Components\TextInput::make('order_index')
                            ->label('Порядок')
                            ->numeric()
                            ->required(),
                    ]),
                Tables\Actions\DetachAction::make()->label('Видалити')->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()->label('Видалити обрані')->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('order_index')
            ->reorderable('order_index')
            ->emptyStateHeading('Немає книг')
            ->emptyStateDescription('До цієї колекції ще не додано книг.')
            ->emptyStateActions([
                Tables\Actions\AttachAction::make()->label('Додати книгу')->preloadRecordSelect()->multiple(),
            ]);
    }
}
