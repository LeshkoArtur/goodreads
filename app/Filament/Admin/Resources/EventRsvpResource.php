<?php

namespace App\Filament\Admin\Resources;

use App\Enums\EventResponse;
use App\Filament\Admin\Resources\EventRsvpResource\Pages;
use App\Models\EventRsvp;
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
use Illuminate\Database\Eloquent\Model;

class EventRsvpResource extends Resource
{
    protected static ?string $model = EventRsvp::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Функціонал груп';

    protected static ?int $navigationSort = 27;

    public static function getModelLabel(): string
    {
        return 'Відповідь на подію';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Відповіді на події';
    }

    public static function getNavigationLabel(): string
    {
        return 'Відповіді на події';
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->event->title.' - '.$record->user->username;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['event', 'user']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Відповідь на подію')
                    ->description('RSVP користувача на подію групи')
                    ->schema([
                        Select::make('group_event_id')
                            ->relationship('event', 'title')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Подія')
                            ->helperText('Подія групи'),
                        Select::make('user_id')
                            ->relationship('user', 'username')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Користувач')
                            ->helperText('Учасник групи'),
                        Select::make('response')
                            ->options(EventResponse::class)
                            ->required()
                            ->native(false)
                            ->label('Відповідь')
                            ->helperText('Прийде, можливо прийде, не прийде'),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event.title')
                    ->label('Подія')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.username')
                    ->label('Користувач')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('response')
                    ->label('Відповідь')
                    ->badge(),
                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('event')
                    ->relationship('event', 'title')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->label('Подія'),
                SelectFilter::make('user')
                    ->relationship('user', 'username')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->label('Користувач'),
                SelectFilter::make('response')
                    ->options(EventResponse::class)
                    ->label('Відповідь'),
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
            'index' => Pages\ListEventRsvps::route('/'),
            'create' => Pages\CreateEventRsvp::route('/create'),
            'view' => Pages\ViewEventRsvp::route('/{record}'),
            'edit' => Pages\EditEventRsvp::route('/{record}/edit'),
        ];
    }
}
