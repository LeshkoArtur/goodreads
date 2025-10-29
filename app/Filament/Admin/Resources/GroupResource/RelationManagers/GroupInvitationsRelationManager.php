<?php

namespace App\Filament\Admin\Resources\GroupResource\RelationManagers;

use App\Enums\InvitationStatus;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class GroupInvitationsRelationManager extends RelationManager
{
    protected static string $relationship = 'groupInvitations';

    protected static ?string $title = 'Запрошення';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('inviter.profile_picture')
                    ->label('Хто запросив')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                Tables\Columns\TextColumn::make('inviter.username')
                    ->label('Запросив')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('invitee.profile_picture')
                    ->label('Кого запросив')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                Tables\Columns\TextColumn::make('invitee.username')
                    ->label('Кандидат')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('invitee.email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (?InvitationStatus $state) => match ($state) {
                        InvitationStatus::PENDING => 'warning',
                        InvitationStatus::ACCEPTED => 'success',
                        InvitationStatus::REJECTED => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('sent_at')
                    ->label('Відправлено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('responded_at')
                    ->label('Відповів')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->placeholder('—')
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options(InvitationStatus::class),
            ])
            ->actions([
                Tables\Actions\Action::make('resend')
                    ->label('Надіслати повторно')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->visible(fn ($record) => $record->status === InvitationStatus::PENDING)
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['sent_at' => now()])),
                Tables\Actions\Action::make('revoke')
                    ->label('Відкликати')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => $record->status === InvitationStatus::PENDING)
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['status' => InvitationStatus::REJECTED, 'responded_at' => now()])),
                Tables\Actions\DeleteAction::make()
                    ->label('Видалити')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Видалити обрані')
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('sent_at', 'desc')
            ->emptyStateHeading('Немає запрошень')
            ->emptyStateDescription('У цій групі ще не було відправлено запрошень.');
    }
}
