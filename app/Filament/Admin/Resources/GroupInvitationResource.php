<?php

namespace App\Filament\Admin\Resources;

use App\Enums\InvitationStatus;
use App\Filament\Admin\Resources\GroupInvitationResource\Pages;
use App\Models\GroupInvitation;
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

class GroupInvitationResource extends Resource
{
    protected static ?string $model = GroupInvitation::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Функціонал груп';

    protected static ?int $navigationSort = 28;

    public static function getModelLabel(): string
    {
        return 'Запрошення в групу';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Запрошення в групи';
    }

    public static function getNavigationLabel(): string
    {
        return 'Запрошення в групи';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['group', 'inviter', 'invitee']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Інформація про запрошення')
                    ->description('Деталі запрошення користувача до групи')
                    ->schema([
                        Select::make('group_id')
                            ->relationship('group', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Група')
                            ->helperText('Оберіть групу, до якої надсилається запрошення'),
                        Select::make('inviter_id')
                            ->relationship('inviter', 'username')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Хто запросив')
                            ->helperText('Користувач, який надсилає запрошення'),
                        Select::make('invitee_id')
                            ->relationship('invitee', 'username')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Кого запросили')
                            ->helperText('Користувач, який отримує запрошення'),
                        Select::make('status')
                            ->options(InvitationStatus::class)
                            ->required()
                            ->native(false)
                            ->label('Статус')
                            ->helperText('Поточний стан запрошення'),
                    ])
                    ->columns(2),
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
                    ->weight('bold'),
                TextColumn::make('inviter.username')
                    ->label('Хто запросив')
                    ->searchable()
                    ->sortable()
                    ->description(fn (GroupInvitation $record): string => $record->inviter?->email ?? ''
                    ),
                TextColumn::make('invitee.username')
                    ->label('Кого запросили')
                    ->searchable()
                    ->sortable()
                    ->description(fn (GroupInvitation $record): string => $record->invitee?->email ?? ''
                    ),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (?InvitationStatus $state): string|array|null => $state?->getColor())
                    ->sortable()
                    ->searchable(),
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
                SelectFilter::make('inviter')
                    ->relationship('inviter', 'username')
                    ->label('Хто запросив')
                    ->searchable()
                    ->multiple(),
                SelectFilter::make('invitee')
                    ->relationship('invitee', 'username')
                    ->label('Кого запросили')
                    ->searchable()
                    ->multiple(),
                SelectFilter::make('status')
                    ->options(InvitationStatus::class)
                    ->label('Статус')
                    ->native(false)
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
            'index' => Pages\ListGroupInvitations::route('/'),
            'create' => Pages\CreateGroupInvitation::route('/create'),
            'view' => Pages\ViewGroupInvitation::route('/{record}'),
            'edit' => Pages\EditGroupInvitation::route('/{record}/edit'),
        ];
    }
}
