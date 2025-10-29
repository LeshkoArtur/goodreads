<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\GroupPollResource\Pages;
use App\Models\GroupPoll;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GroupPollResource extends Resource
{
    protected static ?string $model = GroupPoll::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Функціонал груп';

    protected static ?int $navigationSort = 23;

    public static function getModelLabel(): string
    {
        return 'Опитування';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Опитування';
    }

    public static function getNavigationLabel(): string
    {
        return 'Опитування';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['group', 'creator']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основна інформація')
                    ->description('Базові дані про опитування групи')
                    ->schema([
                        Select::make('group_id')
                            ->relationship('group', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Група')
                            ->helperText('Оберіть групу, для якої створюється опитування'),
                        Select::make('creator_id')
                            ->relationship('creator', 'username')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Автор')
                            ->helperText('Користувач, який створив опитування'),
                        TextInput::make('question')
                            ->required()
                            ->maxLength(255)
                            ->label('Питання')
                            ->helperText('Текст питання опитування')
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->required()
                            ->default(true)
                            ->label('Активне')
                            ->helperText('Чи можуть користувачі голосувати'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')
                    ->label('Питання')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(50),
                TextColumn::make('group.name')
                    ->label('Група')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('creator.username')
                    ->label('Автор')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->label('Активне')
                    ->boolean()
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
                    ->relationship('group', 'name')
                    ->label('Група')
                    ->searchable()
                    ->multiple(),
                SelectFilter::make('creator')
                    ->relationship('creator', 'username')
                    ->label('Автор')
                    ->searchable()
                    ->multiple(),
                TernaryFilter::make('is_active')
                    ->label('Активне')
                    ->placeholder('Всі опитування')
                    ->trueLabel('Тільки активні')
                    ->falseLabel('Тільки неактивні'),
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
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();
    }

    public static function getRelations(): array
    {
        return [
            GroupPollResource\RelationManagers\PollOptionsRelationManager::class,
            GroupPollResource\RelationManagers\PollVotesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGroupPolls::route('/'),
            'create' => Pages\CreateGroupPoll::route('/create'),
            'view' => Pages\ViewGroupPoll::route('/{record}'),
            'edit' => Pages\EditGroupPoll::route('/{record}/edit'),
        ];
    }
}
