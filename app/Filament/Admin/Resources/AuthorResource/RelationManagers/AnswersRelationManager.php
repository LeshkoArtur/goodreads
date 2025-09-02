<?php

namespace App\Filament\Admin\Resources\AuthorResource\RelationManagers;

use App\Enums\AnswerStatus;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class AnswersRelationManager extends RelationManager
{
    protected static string $relationship = 'answers';

    protected static ?string $recordTitleAttribute = 'content';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Відповіді автора') . ' ' . $ownerRecord->name;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('question_id')
                    ->label(__('Питання'))
                    ->relationship('question', 'content')
                    ->required()
                    ->searchable()
                    ->preload(),

                Textarea::make('content')
                    ->label(__('Відповідь'))
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),

                DateTimePicker::make('published_at')
                    ->label(__('Дата публікації'))
                    ->nullable(),

                Select::make('answer_status')
                    ->label(__('Статус'))
                    ->options(AnswerStatus::class)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question.content')
                    ->label(__('Питання'))
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->question?->content)
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->question ? route('filament.admin.resources.author-questions.view', $record->question_id) : null),

                TextColumn::make('content')
                    ->label(__('Відповідь'))
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->content)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('answer_status')
                    ->label(__('Статус'))
                    ->badge()
                    ->formatStateUsing(fn (?AnswerStatus $state) => $state?->getLabel())
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('published_at')
                    ->label(__('Дата публікації'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('Дата створення'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('Дата оновлення'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('answer_status')
                    ->label(__('Статус'))
                    ->options(AnswerStatus::class)
                    ->multiple()
                    ->indicator(__('Статус')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('Додати відповідь')),
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
