<?php

namespace App\Filament\Admin\Resources\GroupResource\RelationManagers;

use App\Enums\MemberRole;
use App\Enums\MemberStatus;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    protected static ?string $recordTitleAttribute = 'username';

    protected static ?string $title = 'Учасники групи';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('username')
            ->columns([
                Tables\Columns\ImageColumn::make('profile_picture')
                    ->label('Аватар')
                    ->circular()
                    ->size(50)
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                Tables\Columns\TextColumn::make('username')
                    ->label('Користувач')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Роль')
                    ->badge()
                    ->color(fn (?MemberRole $state) => match ($state) {
                        MemberRole::ADMIN => 'danger',
                        MemberRole::MODERATOR => 'warning',
                        MemberRole::MEMBER => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (?MemberStatus $state) => match ($state) {
                        MemberStatus::ACTIVE => 'success',
                        MemberStatus::INACTIVE => 'gray',
                        MemberStatus::BANNED => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('joined_at')
                    ->label('Приєднався')
                    ->dateTime('d.m.Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('posts_count')
                    ->label('Постів')
                    ->counts('groupPosts')
                    ->badge()
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Роль')
                    ->options(MemberRole::class),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options(MemberStatus::class),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Додати учасника')
                    ->preloadRecordSelect()
                    ->modalHeading('Додати учасника до групи')
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\Select::make('role')
                            ->label('Роль у групі')
                            ->options(MemberRole::class)
                            ->required()
                            ->default(MemberRole::MEMBER)
                            ->native(false)
                            ->helperText('Виберіть роль для нового учасника'),
                        Forms\Components\Select::make('status')
                            ->label('Статус')
                            ->options(MemberStatus::class)
                            ->required()
                            ->default(MemberStatus::ACTIVE)
                            ->native(false),
                        Forms\Components\DateTimePicker::make('joined_at')
                            ->label('Дата приєднання')
                            ->default(now())
                            ->required()
                            ->native(false),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Редагувати')
                    ->modalHeading('Редагувати роль та статус')
                    ->form([
                        Forms\Components\Select::make('role')
                            ->label('Роль у групі')
                            ->options(MemberRole::class)
                            ->required()
                            ->native(false),
                        Forms\Components\Select::make('status')
                            ->label('Статус')
                            ->options(MemberStatus::class)
                            ->required()
                            ->native(false),
                        Forms\Components\DateTimePicker::make('joined_at')
                            ->label('Дата приєднання')
                            ->native(false)
                            ->disabled(),
                    ]),
                Tables\Actions\Action::make('ban')
                    ->label('Забанити')
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Забанити учасника?')
                    ->modalDescription('Учасник не зможе переглядати та взаємодіяти з групою.')
                    ->visible(fn ($record) => $record->pivot?->status !== MemberStatus::BANNED)
                    ->action(fn ($record) => $record->pivot->update(['status' => MemberStatus::BANNED])),
                Tables\Actions\Action::make('unban')
                    ->label('Розбанити')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->pivot?->status === MemberStatus::BANNED)
                    ->action(fn ($record) => $record->pivot->update(['status' => MemberStatus::ACTIVE])),
                Tables\Actions\DetachAction::make()
                    ->label('Видалити')
                    ->requiresConfirmation()
                    ->modalHeading('Видалити учасника?')
                    ->modalDescription('Учасник буде виключений з групи.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('changeRole')
                        ->label('Змінити роль')
                        ->icon('heroicon-o-user-group')
                        ->color('warning')
                        ->form([
                            Forms\Components\Select::make('role')
                                ->label('Нова роль')
                                ->options(MemberRole::class)
                                ->required()
                                ->native(false),
                        ])
                        ->action(function (Collection $records, array $data) {
                            foreach ($records as $record) {
                                $record->pivot->update(['role' => $data['role']]);
                            }
                        }),
                    Tables\Actions\BulkAction::make('ban')
                        ->label('Забанити обраних')
                        ->icon('heroicon-o-no-symbol')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->pivot->update(['status' => MemberStatus::BANNED]);
                            }
                        }),
                    Tables\Actions\DetachBulkAction::make()
                        ->label('Видалити обраних')
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('joined_at', 'desc')
            ->emptyStateHeading('Немає учасників')
            ->emptyStateDescription('Додайте першого учасника до групи.')
            ->emptyStateActions([
                Tables\Actions\AttachAction::make()
                    ->label('Додати учасника')
                    ->preloadRecordSelect(),
            ]);
    }
}
