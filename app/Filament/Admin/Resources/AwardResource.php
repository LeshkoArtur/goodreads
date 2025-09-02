<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AwardResource\Pages\CreateAward;
use App\Filament\Admin\Resources\AwardResource\Pages\EditAward;
use App\Filament\Admin\Resources\AwardResource\Pages\ListAwards;
use App\Filament\Admin\Resources\AwardResource\Pages\ViewAward;
use App\Filament\Admin\Resources\AwardResource\RelationManagers\NominationsRelationManager;
use App\Models\Award;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AwardResource extends Resource
{
    protected static ?string $model = Award::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationGroup = 'Нагороди';

    protected static ?int $navigationSort = 13;

    public static function getNavigationLabel(): string
    {
        return __('Нагороди');
    }

    public static function getModelLabel(): string
    {
        return __('Нагорода');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Нагороди');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('Назва'))
                    ->required()
                    ->maxLength(255)
                    ->unique(Award::class, 'name', ignoreRecord: true),

                TextInput::make('year')
                    ->label(__('Рік'))
                    ->numeric()
                    ->required()
                    ->minValue(1800)
                    ->maxValue(date('Y') + 1),

                Textarea::make('description')
                    ->label(__('Опис'))
                    ->maxLength(65535)
                    ->nullable()
                    ->columnSpanFull(),

                TextInput::make('organizer')
                    ->label(__('Організатор'))
                    ->maxLength(255)
                    ->nullable(),

                TextInput::make('country')
                    ->label(__('Країна'))
                    ->maxLength(255)
                    ->nullable(),

                DatePicker::make('ceremony_date')
                    ->label(__('Дата церемонії'))
                    ->nullable(),
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

                TextColumn::make('name')
                    ->label(__('Назва'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.admin.resources.awards.view', $record->id)),

                TextColumn::make('year')
                    ->label(__('Рік'))
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('organizer')
                    ->label(__('Організатор'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('country')
                    ->label(__('Країна'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('ceremony_date')
                    ->label(__('Дата церемонії'))
                    ->date()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('nominations_count')
                    ->label(__('Кількість номінацій'))
                    ->counts('nominations')
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
                SelectFilter::make('year')
                    ->label(__('Рік'))
                    ->options(fn () => Award::pluck('year', 'year')->unique()->toArray())
                    ->multiple()
                    ->indicator(__('Рік')),

                SelectFilter::make('organizer')
                    ->label(__('Організатор'))
                    ->options(fn () => Award::pluck('organizer', 'organizer')->filter()->toArray())
                    ->multiple()
                    ->indicator(__('Організатор')),

                SelectFilter::make('country')
                    ->label(__('Країна'))
                    ->options(fn () => Award::pluck('country', 'country')->filter()->toArray())
                    ->multiple()
                    ->indicator(__('Країна')),
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
            ->defaultSort('year', 'desc')
            ->groups([
                'year',
                'organizer',
                'country',
            ]);
    }

    public static function getRelations(): array
    {
        return [
            NominationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAwards::route('/'),
            'create' => CreateAward::route('/create'),
            'view' => ViewAward::route('/{record}'),
            'edit' => EditAward::route('/{record}/edit'),
        ];
    }
}
