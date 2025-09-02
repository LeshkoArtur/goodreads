<?php

namespace App\Filament\Admin\Resources\GroupResource\RelationManagers;

use App\Enums\InvitationStatus;
use App\Models\Group;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class GroupInvitationsRelationManager extends RelationManager
{
    protected static string $relationship = 'invitations';

    protected static ?string $recordTitleAttribute = 'invitee_id';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Запрошення до групи') . ' ' . $ownerRecord->name;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make(__('Запрошення'))
                    ->schema([
                        Select::make('inviter_id')
                            ->label(__('Відправник'))
                            ->relationship('inviter', 'username')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('invitee_id')
                            ->label(__('Отримувач'))
                            ->relationship('invitee', 'username')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('status')
                            ->label(__('Статус'))
                            ->options(InvitationStatus::class)
                            ->required(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('inviter.username')
                    ->label(__('Відправник'))
                    ->searchable()
                    ->sortable()
                    ->url(fn (Model $record): ?string => $record->inviter ? route('filament.resources.users.view', $record->inviter_id) : null),
                TextColumn::make('invitee.username')
                    ->label(__('Отримувач'))
                    ->searchable()
                    ->sortable()
                    ->url(fn (Model $record): ?string => $record->invitee ? route('filament.resources.users.view', $record->invitee_id) : null),
                TextColumn::make('status')
                    ->label(__('Статус'))
                    ->badge()
                    ->formatStateUsing(fn (?InvitationStatus $state) => $state?->getLabel())
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
                SelectFilter::make('inviter')
                    ->label(__('Відправник'))
                    ->relationship('inviter', 'username')
                    ->searchable()
                    ->multiple()
                    ->indicator(__('Відправник')),
                SelectFilter::make('invitee')
                    ->label(__('Отримувач'))
                    ->relationship('invitee', 'username')
                    ->searchable()
                    ->multiple()
                    ->indicator(__('Отримувач')),
                SelectFilter::make('status')
                    ->label(__('Статус'))
                    ->options(InvitationStatus::class)
                    ->multiple()
                    ->indicator(__('Статус')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('Додати запрошення')),
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
