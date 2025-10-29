<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PollVoteResource\Pages;
use App\Models\PollVote;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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

class PollVoteResource extends Resource
{
    protected static ?string $model = PollVote::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    protected static ?string $navigationGroup = 'Функціонал груп';

    protected static ?int $navigationSort = 25;

    public static function getModelLabel(): string
    {
        return 'Голос';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Голоси';
    }

    public static function getNavigationLabel(): string
    {
        return 'Голоси';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['poll', 'option', 'user']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Голос в опитуванні')
                    ->description('Голос користувача за варіант')
                    ->schema([
                        Select::make('group_poll_id')
                            ->relationship('poll', 'question')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Опитування')
                            ->helperText('Опитування групи'),
                        Select::make('poll_option_id')
                            ->relationship('option', 'text')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Варіант')
                            ->helperText('Вибраний варіант відповіді'),
                        Select::make('user_id')
                            ->relationship('user', 'username')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Користувач')
                            ->helperText('Хто проголосував'),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('poll.question')
                    ->label('Опитування')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('option.text')
                    ->label('Варіант')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.username')
                    ->label('Користувач')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Дата голосування')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('poll')
                    ->relationship('poll', 'question')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->label('Опитування'),
                SelectFilter::make('user')
                    ->relationship('user', 'username')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->label('Користувач'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPollVotes::route('/'),
            'create' => Pages\CreatePollVote::route('/create'),
            'view' => Pages\ViewPollVote::route('/{record}'),
            'edit' => Pages\EditPollVote::route('/{record}/edit'),
        ];
    }
}
