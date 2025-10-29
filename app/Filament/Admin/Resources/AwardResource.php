<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AwardResource\Pages;
use App\Models\Award;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
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
use Illuminate\Database\Eloquent\Model;

class AwardResource extends Resource
{
    protected static ?string $model = Award::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationGroup = 'Нагороди та номінації';

    protected static ?int $navigationSort = 32;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return 'Нагорода';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Нагороди';
    }

    public static function getNavigationLabel(): string
    {
        return 'Нагороди';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'organizer', 'country'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name.' ('.$record->year.')';
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Організатор' => $record->organizer ?? '—',
            'Країна' => $record->country ?? '—',
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount(['nominations']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основна інформація')
                    ->description('Інформація про нагороду та її організатора')
                    ->schema([
                        TextInput::make('name')
                            ->label('Назва нагороди')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Повна назва літературної нагороди'),
                        TextInput::make('year')
                            ->label('Рік проведення')
                            ->required()
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(now()->year + 1)
                            ->helperText('Рік проведення церемонії'),
                        DatePicker::make('ceremony_date')
                            ->label('Дата церемонії')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                        TextInput::make('organizer')
                            ->label('Організатор')
                            ->maxLength(50)
                            ->helperText('Організатор нагороди (установа, фундація)'),
                        TextInput::make('country')
                            ->label('Країна')
                            ->maxLength(100),
                        Textarea::make('description')
                            ->label('Опис нагороди')
                            ->rows(5)
                            ->maxLength(2000)
                            ->helperText('Історія та опис нагороди (до 2000 символів)')
                            ->columnSpanFull(),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Назва')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Award $record): string => $record->organizer ?? ''
                    ),
                TextColumn::make('year')
                    ->label('Рік')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('primary'),
                TextColumn::make('organizer')
                    ->label('Організатор')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('country')
                    ->label('Країна')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->toggleable(),
                TextColumn::make('nominations_count')
                    ->label('Номінацій')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                TextColumn::make('ceremony_date')
                    ->label('Дата церемонії')
                    ->date('d.m.Y')
                    ->sortable()
                    ->toggleable(),
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
                SelectFilter::make('country')
                    ->label('Країна')
                    ->options(function () {
                        return Award::query()
                            ->whereNotNull('country')
                            ->distinct()
                            ->pluck('country', 'country')
                            ->toArray();
                    })
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
            ->defaultSort('year', 'desc')
            ->striped()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();
    }

    public static function getRelations(): array
    {
        return [
            AwardResource\RelationManagers\NominationsRelationManager::class,
            AwardResource\RelationManagers\NominationEntriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAwards::route('/'),
            'create' => Pages\CreateAward::route('/create'),
            'view' => Pages\ViewAward::route('/{record}'),
            'edit' => Pages\EditAward::route('/{record}/edit'),
        ];
    }
}
