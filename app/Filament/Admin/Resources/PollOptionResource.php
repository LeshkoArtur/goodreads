<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PollOptionResource\Pages;
use App\Models\PollOption;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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

class PollOptionResource extends Resource
{
    protected static ?string $model = PollOption::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?string $navigationGroup = 'Функціонал груп';

    protected static ?int $navigationSort = 24;

    public static function getModelLabel(): string
    {
        return 'Варіант опитування';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Варіанти опитувань';
    }

    public static function getNavigationLabel(): string
    {
        return 'Варіанти опитувань';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['poll']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Варіант опитування')
                    ->description('Варіант відповіді у полі групи')
                    ->schema([
                        Select::make('group_poll_id')
                            ->relationship('poll', 'question')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Опитування')
                            ->helperText('Опитування групи'),
                        TextInput::make('text')
                            ->required()
                            ->maxLength(255)
                            ->label('Текст варіанту')
                            ->helperText('Варіант відповіді'),
                        TextInput::make('vote_count')
                            ->numeric()
                            ->default(0)
                            ->label('Кількість голосів'),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('text')
                    ->label('Текст варіанту')
                    ->searchable(),
                TextColumn::make('poll.question')
                    ->label('Опитування')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('vote_count')
                    ->label('Голоси')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('poll')
                    ->relationship('poll', 'question')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->label('Опитування'),
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
            ->striped();
    }

    public static function getRelations(): array
    {
        return [
            PollOptionResource\RelationManagers\PollVotesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPollOptions::route('/'),
            'create' => Pages\CreatePollOption::route('/create'),
            'view' => Pages\ViewPollOption::route('/{record}'),
            'edit' => Pages\EditPollOption::route('/{record}/edit'),
        ];
    }
}
