<?php

namespace App\Filament\Admin\Resources\PublisherResource\RelationManagers;

use App\Enums\CoverType;
use App\Enums\ReadingFormat;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;

class BooksRelationManager extends RelationManager
{
    protected static string $relationship = 'books';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $title = 'Книги видавництва';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Обкладинка')
                    ->size(50),
                Tables\Columns\TextColumn::make('title')
                    ->label('Назва')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('published_date')
                    ->label('Дата видання')
                    ->date('d.m.Y')
                    ->sortable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('isbn')
                    ->label('ISBN')
                    ->copyable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('format')
                    ->label('Формат')
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Ціна')
                    ->money('UAH')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('format')
                    ->label('Формат')
                    ->options(ReadingFormat::class),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Додати книгу')
                    ->preloadRecordSelect()
                    ->modalHeading('Додати книгу до видавництва')
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\DatePicker::make('published_date')
                            ->label('Дата публікації')
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('isbn')
                            ->label('ISBN')
                            ->maxLength(20),
                        Forms\Components\Select::make('format')
                            ->label('Формат')
                            ->options(ReadingFormat::class)
                            ->required()
                            ->native(false),
                        Forms\Components\Select::make('cover_type')
                            ->label('Тип обкладинки')
                            ->options(CoverType::class)
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('price')
                            ->label('Ціна')
                            ->numeric()
                            ->prefix('₴'),
                        Forms\Components\TextInput::make('circulation')
                            ->label('Тираж')
                            ->numeric(),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Редагувати')
                    ->form([
                        Forms\Components\DatePicker::make('published_date')
                            ->label('Дата публікації')
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('isbn')->label('ISBN'),
                        Forms\Components\Select::make('format')
                            ->label('Формат')
                            ->options(ReadingFormat::class)
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('price')
                            ->label('Ціна')
                            ->numeric()
                            ->prefix('₴'),
                    ]),
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
            ->defaultSort('published_date', 'desc')
            ->emptyStateHeading('Немає книг')
            ->emptyStateDescription('Це видавництво ще не видавало книг.')
            ->emptyStateActions([
                Tables\Actions\AttachAction::make()->label('Додати книгу')->preloadRecordSelect(),
            ]);
    }
}
