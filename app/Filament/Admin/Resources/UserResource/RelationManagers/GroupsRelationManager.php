<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use App\Enums\MemberRole;
use App\Enums\MemberStatus;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;

class GroupsRelationManager extends RelationManager
{
    protected static string $relationship = 'groups';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Групи користувача';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Обкладинка')
                    ->size(50),
                Tables\Columns\TextColumn::make('name')
                    ->label('Назва групи')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
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
                Tables\Columns\IconColumn::make('is_public')
                    ->label('Публічна')
                    ->boolean()
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
                    ->label('Додати до групи')
                    ->preloadRecordSelect()
                    ->modalHeading('Додати користувача до групи')
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\Select::make('role')
                            ->label('Роль у групі')
                            ->options(MemberRole::class)
                            ->required()
                            ->default(MemberRole::MEMBER)
                            ->native(false),
                        Forms\Components\Select::make('status')
                            ->label('Статус')
                            ->options(MemberStatus::class)
                            ->required()
                            ->default(MemberStatus::ACTIVE)
                            ->native(false),
                        Forms\Components\DateTimePicker::make('joined_at')
                            ->label('Дата приєднання')
                            ->default(now())
                            ->native(false),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Редагувати')
                    ->modalHeading('Редагувати членство')
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
                Tables\Actions\DetachAction::make()
                    ->label('Видалити з групи')
                    ->requiresConfirmation()
                    ->modalHeading('Видалити користувача з групи?')
                    ->modalDescription('Користувач буде виключений з цієї групи.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->label('Видалити з груп')
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('joined_at', 'desc')
            ->emptyStateHeading('Немає груп')
            ->emptyStateDescription('Користувач не є членом жодної групи.');
    }
}
