<?php

namespace App\Filament\Admin\Resources\AuthorResource\RelationManagers;

use App\Enums\QuestionStatus;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    protected static ?string $recordTitleAttribute = 'content';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Питання до автора') . ' ' . $ownerRecord->name;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label(__('Користувач'))
                    ->relationship('user', 'username')
                    ->required()
                    ->searchable()
                    ->preload(),

                Select::make('book_id')
                    ->label(__('Книга'))
                    ->relationship('book', 'title')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                Textarea::make('content')
                    ->label(__('Питання'))
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),

                Select::make('question_status')
                    ->label(__('Статус'))
                    ->options(QuestionStatus::class)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.username')
                    ->label(__('Користувач'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->user ? route('filament.admin.resources.users.view', $record->user_id) : null),

                TextColumn::make('book.title')
                    ->label(__('Книга'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->book ? route('filament.admin.resources.books.view', $record->book_id) : null)
                    ->toggleable(),

                TextColumn::make('content')
                    ->label(__('Питання'))
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->content)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('question_status')
                    ->label(__('Статус'))
                    ->badge()
                    ->formatStateUsing(fn (?QuestionStatus $state) => $state?->getLabel())
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('answers_count')
                    ->label(__('Кількість відповідей'))
                    ->counts('answers')
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
                SelectFilter::make('question_status')
                    ->label(__('Статус'))
                    ->options(QuestionStatus::class)
                    ->multiple()
                    ->indicator(__('Статус')),

                SelectFilter::make('user_id')
                    ->label(__('Користувач'))
                    ->relationship('user', 'username')
                    ->multiple()
                    ->indicator(__('Користувач')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('Додати питання')),
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
