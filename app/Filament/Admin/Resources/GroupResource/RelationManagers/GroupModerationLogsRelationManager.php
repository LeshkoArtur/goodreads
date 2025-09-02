<?php

namespace App\Filament\Admin\Resources\GroupResource\RelationManagers;

use App\Models\Group;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class GroupModerationLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'moderationLogs';

    protected static ?string $recordTitleAttribute = 'action';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Логи модерації для групи') . ' ' . $ownerRecord->name;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make(__('Лог модерації'))
                    ->schema([
                        Select::make('moderator_id')
                            ->label(__('Модератор'))
                            ->relationship('moderator', 'username')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('action')
                            ->label(__('Дія'))
                            ->options([
                                'approve' => __('Схвалено'),
                                'reject' => __('Відхилено'),
                                'delete' => __('Видалено'),
                                'warn' => __('Попередження'),
                            ])
                            ->required(),
                        Textarea::make('description')
                            ->label(__('Опис'))
                            ->maxLength(65535)
                            ->rows(5)
                            ->nullable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('moderator.username')
                    ->label(__('Модератор'))
                    ->searchable()
                    ->sortable()
                    ->url(fn (Model $record): ?string => $record->moderator ? route('filament.resources.users.view', $record->moderator_id) : null),
                TextColumn::make('action')
                    ->label(__('Дія'))
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'approve' => __('Схвалено'),
                        'reject' => __('Відхилено'),
                        'delete' => __('Видалено'),
                        'warn' => __('Попередження'),
                        default => $state ?? '-',
                    })
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('description')
                    ->label(__('Опис'))
                    ->limit(50)
                    ->tooltip(fn (Model $record): ?string => $record->description)
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('targetable_type')
                    ->label(__('Тип об’єкта'))
                    ->formatStateUsing(fn ($state) => class_basename($state) ?? '-')
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
                SelectFilter::make('moderator')
                    ->label(__('Модератор'))
                    ->relationship('moderator', 'username')
                    ->searchable()
                    ->multiple()
                    ->indicator(__('Модератор')),
                SelectFilter::make('action')
                    ->label(__('Дія'))
                    ->options([
                        'approve' => __('Схвалено'),
                        'reject' => __('Відхилено'),
                        'delete' => __('Видалено'),
                        'warn' => __('Попередження'),
                    ])
                    ->multiple()
                    ->indicator(__('Дія')),
                SelectFilter::make('targetable_type')
                    ->label(__('Тип об’єкта'))
                    ->options([
                        'App\Models\GroupPost' => __('Публікація'),
                        'App\Models\Comment' => __('Коментар'),
                    ])
                    ->multiple()
                    ->indicator(__('Тип об’єкта')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('Додати лог модерації')),
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
