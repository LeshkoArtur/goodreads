<?php

namespace App\Filament\Admin\Resources\GroupResource\RelationManagers;

use App\Enums\EventStatus;
use App\Models\Group;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class GroupEventsRelationManager extends RelationManager
{
    protected static string $relationship = 'events';

    protected static ?string $recordTitleAttribute = 'title';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Події групи') . ' ' . $ownerRecord->name;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make(__('Подія'))
                    ->schema([
                        Select::make('creator_id')
                            ->label(__('Творець'))
                            ->relationship('creator', 'username')
                            ->required()
                            ->searchable()
                            ->preload(),
                        TextInput::make('title')
                            ->label(__('Назва'))
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->label(__('Опис'))
                            ->maxLength(65535)
                            ->nullable()
                            ->rows(5)
                            ->columnSpanFull(),
                        DateTimePicker::make('event_date')
                            ->label(__('Дата події'))
                            ->required()
                            ->minDate(now()),
                        TextInput::make('location')
                            ->label(__('Місце проведення'))
                            ->maxLength(255)
                            ->nullable(),
                        Select::make('status')
                            ->label(__('Статус'))
                            ->options(EventStatus::class)
                            ->required(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('Назва'))
                    ->searchable()
                    ->sortable()
                    ->url(fn (Model $record): string => route('filament.resources.group-events.view', $record->id)),
                TextColumn::make('creator.username')
                    ->label(__('Творець'))
                    ->searchable()
                    ->sortable()
                    ->url(fn (Model $record): ?string => $record->creator ? route('filament.resources.users.view', $record->creator_id) : null),
                TextColumn::make('event_date')
                    ->label(__('Дата події'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('location')
                    ->label(__('Місце'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->label(__('Статус'))
                    ->badge()
                    ->formatStateUsing(fn (?EventStatus $state) => $state?->getLabel())
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('rsvps_count')
                    ->label(__('Кількість RSVP'))
                    ->counts('rsvps')
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
                SelectFilter::make('status')
                    ->label(__('Статус'))
                    ->options(EventStatus::class)
                    ->multiple()
                    ->indicator(__('Статус')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('Додати подію')),
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
            ->defaultSort('event_date', 'desc');
    }
}
