<?php

namespace App\Filament\Admin\Resources\GroupResource\RelationManagers;

use App\Models\Group;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class GroupPollsRelationManager extends RelationManager
{
    protected static string $relationship = 'polls';

    protected static ?string $recordTitleAttribute = 'question';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Опитування групи') . ' ' . $ownerRecord->name;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make(__('Опитування'))
                    ->schema([
                        Select::make('creator_id')
                            ->label(__('Творець'))
                            ->relationship('creator', 'username')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('question')
                            ->label(__('Питання'))
                            ->required()
                            ->maxLength(255),
                        Toggle::make('is_active')
                            ->label(__('Активне'))
                            ->default(true),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')
                    ->label(__('Питання'))
                    ->searchable()
                    ->sortable()
                    ->url(fn (Model $record): string => route('filament.resources.group-polls.view', $record->id)),
                TextColumn::make('creator.username')
                    ->label(__('Творець'))
                    ->searchable()
                    ->sortable()
                    ->url(fn (Model $record): ?string => $record->creator ? route('filament.resources.users.view', $record->creator_id) : null),
                IconColumn::make('is_active')
                    ->label(__('Активність'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('options_count')
                    ->label(__('Кількість варіантів'))
                    ->counts('options')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('votes_count')
                    ->label(__('Кількість голосів'))
                    ->counts('votes')
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
                SelectFilter::make('creator')
                    ->label(__('Творець'))
                    ->relationship('creator', 'username')
                    ->searchable()
                    ->multiple()
                    ->indicator(__('Творець')),
                TernaryFilter::make('is_active')
                    ->label(__('Активність'))
                    ->placeholder(__('Всі'))
                    ->trueLabel(__('Активні'))
                    ->falseLabel(__('Неактивні'))
                    ->indicator(__('Активність')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('Додати опитування')),
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
