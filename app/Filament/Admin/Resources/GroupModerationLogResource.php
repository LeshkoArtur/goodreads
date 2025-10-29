<?php

namespace App\Filament\Admin\Resources;

use App\Enums\ModerationAction;
use App\Filament\Admin\Resources\GroupModerationLogResource\Pages;
use App\Models\Comment;
use App\Models\GroupModerationLog;
use App\Models\GroupPost;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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

class GroupModerationLogResource extends Resource
{
    protected static ?string $model = GroupModerationLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Функціонал груп';

    protected static ?int $navigationSort = 29;

    public static function getModelLabel(): string
    {
        return 'Лог модерації';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Логи модерації';
    }

    public static function getNavigationLabel(): string
    {
        return 'Логи модерації';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['group', 'moderator', 'targetable']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Інформація про модерацію')
                    ->description('Основні дані про дію модератора')
                    ->schema([
                        Select::make('group_id')
                            ->label('Група')
                            ->relationship('group', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->helperText('Група, в якій відбулася модерація')
                            ->columnSpan(1),
                        Select::make('moderator_id')
                            ->label('Модератор')
                            ->relationship('moderator', 'username')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->helperText('Користувач, який виконав модераційну дію')
                            ->columnSpan(1),
                        Select::make('action')
                            ->label('Дія')
                            ->options(ModerationAction::class)
                            ->required()
                            ->native(false)
                            ->helperText('Тип модераційної дії')
                            ->columnSpan(1),
                    ])->columns(3),

                Section::make('Ціль модерації')
                    ->description('Об\'єкт, на який спрямована дія модератора')
                    ->schema([
                        MorphToSelect::make('targetable')
                            ->label('Ціль модерації')
                            ->types([
                                MorphToSelect\Type::make(GroupPost::class)
                                    ->titleAttribute('content')
                                    ->label('Пост групи'),
                                MorphToSelect\Type::make(Comment::class)
                                    ->titleAttribute('content')
                                    ->label('Коментар'),
                            ])
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Опис дії')
                            ->rows(4)
                            ->maxLength(1000)
                            ->helperText('Детальний опис причини модераційної дії')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('group.name')
                    ->label('Група')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('moderator.username')
                    ->label('Модератор')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (GroupModerationLog $record): string => $record->moderator->email ?? ''
                    ),
                TextColumn::make('action')
                    ->label('Дія')
                    ->badge()
                    ->color(fn (?ModerationAction $state): string|array|null => $state?->getColor())
                    ->sortable()
                    ->searchable(),
                TextColumn::make('targetable_type')
                    ->label('Тип цілі')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'App\\Models\\GroupPost' => 'Пост групи',
                        'App\\Models\\Comment' => 'Коментар',
                        default => class_basename($state),
                    }
                    )
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Опис')
                    ->limit(50)
                    ->tooltip(fn (GroupModerationLog $record): ?string => $record->description)
                    ->wrap()
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(),
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
                    ->preload()
                    ->multiple(),
                SelectFilter::make('moderator')
                    ->label('Модератор')
                    ->relationship('moderator', 'username')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                SelectFilter::make('action')
                    ->label('Дія')
                    ->options(ModerationAction::class)
                    ->native(false)
                    ->multiple(),
                SelectFilter::make('targetable_type')
                    ->label('Тип цілі')
                    ->options([
                        'App\\Models\\GroupPost' => 'Пост групи',
                        'App\\Models\\Comment' => 'Коментар',
                    ])
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
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGroupModerationLogs::route('/'),
            'create' => Pages\CreateGroupModerationLog::route('/create'),
            'view' => Pages\ViewGroupModerationLog::route('/{record}'),
            'edit' => Pages\EditGroupModerationLog::route('/{record}/edit'),
        ];
    }
}
