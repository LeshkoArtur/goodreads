<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\GroupEventResource\Pages\CreateGroupEvent;
use App\Filament\Admin\Resources\GroupEventResource\Pages\EditGroupEvent;
use App\Filament\Admin\Resources\GroupEventResource\Pages\ListGroupEvents;
use App\Filament\Admin\Resources\GroupEventResource\Pages\ViewGroupEvent;
use App\Filament\Admin\Resources\GroupEventResource\RelationManagers\RsvpsRelationManager;
use App\Enums\EventStatus;
use App\Models\GroupEvent;
use Filament\Forms\Form;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GroupEventResource extends Resource
{
    protected static ?string $model = GroupEvent::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Події груп';

    protected static ?int $navigationSort = 12;

    public static function getNavigationLabel(): string
    {
        return __('Події груп');
    }

    public static function getModelLabel(): string
    {
        return __('Подія групи');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Події груп');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('group_id')
                    ->label(__('Група'))
                    ->relationship('group', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

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
                    ->columnSpanFull(),

                DateTimePicker::make('event_date')
                    ->label(__('Дата події'))
                    ->required(),

                TextInput::make('location')
                    ->label(__('Місце проведення'))
                    ->maxLength(255)
                    ->nullable(),

                Select::make('status')
                    ->label(__('Статус'))
                    ->options(EventStatus::class)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ImageColumn::make('group.cover_image')
                    ->label(__('Обкладинка групи'))
                    ->getStateUsing(fn ($record) => $record->group ? $record->group->getFirstMediaUrl('cover_image') : null)
                    ->circular()
                    ->defaultImageUrl(url('path/to/default-group-image.jpg')),

                TextColumn::make('group.name')
                    ->label(__('Група'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->group ? route('filament.admin.resources.groups.view', $record->group_id) : null),

                TextColumn::make('creator.username')
                    ->label(__('Творець'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->creator ? route('filament.admin.resources.users.view', $record->creator_id) : null),

                TextColumn::make('title')
                    ->label(__('Назва'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.admin.resources.group-events.view', $record->id)),

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
                SelectFilter::make('group_id')
                    ->label(__('Група'))
                    ->relationship('group', 'name')
                    ->multiple()
                    ->indicator(__('Група')),

                SelectFilter::make('creator_id')
                    ->label(__('Творець'))
                    ->relationship('creator', 'username')
                    ->multiple()
                    ->indicator(__('Творець')),

                SelectFilter::make('status')
                    ->label(__('Статус'))
                    ->options(EventStatus::class)
                    ->multiple()
                    ->indicator(__('Статус')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('event_date', 'desc')
            ->groups([
                'group_id',
                'creator_id',
                'status',
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RsvpsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGroupEvents::route('/'),
            'create' => CreateGroupEvent::route('/create'),
            'view' => ViewGroupEvent::route('/{record}'),
            'edit' => EditGroupEvent::route('/{record}/edit'),
        ];
    }
}
