<?php

namespace App\Filament\Admin\Resources;

use App\Enums\EventStatus;
use App\Filament\Admin\Resources\GroupEventResource\Pages;
use App\Models\GroupEvent;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GroupEventResource extends Resource
{
    protected static ?string $model = GroupEvent::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Функціонал груп';

    protected static ?int $navigationSort = 26;

    public static function getModelLabel(): string
    {
        return 'Подія';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Події';
    }

    public static function getNavigationLabel(): string
    {
        return 'Події';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount(['rsvps']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основна інформація')
                    ->description('Базові дані про подію групи')
                    ->schema([
                        Select::make('group_id')
                            ->label('Група')
                            ->relationship('group', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->helperText('Оберіть групу, для якої створюється подія'),
                        Select::make('creator_id')
                            ->label('Створив')
                            ->relationship('creator', 'username')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->helperText('Користувач, який створив подію'),
                        TextInput::make('title')
                            ->label('Назва події')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Коротка назва події')
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Опис')
                            ->rows(4)
                            ->helperText('Детальний опис події')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Деталі події')
                    ->description('Час, місце та статус події')
                    ->schema([
                        DateTimePicker::make('event_date')
                            ->label('Дата та час події')
                            ->required()
                            ->native(false)
                            ->displayFormat('d.m.Y H:i')
                            ->helperText('Коли відбудеться подія'),
                        TextInput::make('location')
                            ->label('Локація')
                            ->maxLength(255)
                            ->helperText('Місце проведення події'),
                        Select::make('status')
                            ->label('Статус')
                            ->options(EventStatus::class)
                            ->required()
                            ->native(false)
                            ->helperText('Поточний стан події'),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Подія')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (GroupEvent $record): string => $record->group?->name ?? ''
                    ),
                TextColumn::make('group.name')
                    ->label('Група')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('creator.username')
                    ->label('Створив')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('event_date')
                    ->label('Дата та час')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                TextColumn::make('location')
                    ->label('Локація')
                    ->limit(30)
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (?EventStatus $state): string|array|null => $state?->getColor())
                    ->sortable()
                    ->searchable(),
                TextColumn::make('rsvps_count')
                    ->label('Учасників')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Оновлено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('group')
                    ->label('Група')
                    ->relationship('group', 'name')
                    ->searchable()
                    ->multiple(),
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(EventStatus::class)
                    ->native(false)
                    ->multiple(),
                SelectFilter::make('creator')
                    ->label('Створив')
                    ->relationship('creator', 'username')
                    ->searchable()
                    ->multiple(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('event_date', 'desc')
            ->striped()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();
    }

    public static function getRelations(): array
    {
        return [
            GroupEventResource\RelationManagers\RsvpsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGroupEvents::route('/'),
            'create' => Pages\CreateGroupEvent::route('/create'),
            'edit' => Pages\EditGroupEvent::route('/{record}/edit'),
        ];
    }
}
