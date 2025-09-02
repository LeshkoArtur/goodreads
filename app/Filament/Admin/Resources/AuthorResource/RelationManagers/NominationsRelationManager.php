<?php

namespace App\Filament\Admin\Resources\AuthorResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class NominationsRelationManager extends RelationManager
{
    protected static string $relationship = 'nominations';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Номінації автора') . ' ' . $ownerRecord->name;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('award_id')
                    ->label(__('Нагорода'))
                    ->relationship('award', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                TextInput::make('name')
                    ->label(__('Назва номінації'))
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->label(__('Опис'))
                    ->maxLength(65535)
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('award.name')
                    ->label(__('Нагорода'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->award ? route('filament.admin.resources.awards.view', $record->award_id) : null),

                TextColumn::make('name')
                    ->label(__('Назва номінації'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->label(__('Опис'))
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description)
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('entries_count')
                    ->label(__('Кількість записів'))
                    ->counts('entries')
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
                SelectFilter::make('award_id')
                    ->label(__('Нагорода'))
                    ->relationship('award', 'name')
                    ->multiple()
                    ->indicator(__('Нагорода')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('Додати номінацію')),
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
