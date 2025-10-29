<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class FollowingRelationManager extends RelationManager
{
    protected static string $relationship = 'following';

    protected static ?string $recordTitleAttribute = 'username';

    protected static ?string $title = 'Підписки';

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
                    ->toggleable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Роль')
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('followers_count')
                    ->label('Підписників')
                    ->counts('followers')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('following_count')
                    ->label('Підписок')
                    ->counts('following')
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('pivot.created_at')
                    ->label('Підписався')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Роль')
                    ->options([
                        'user' => 'Користувач',
                        'author' => 'Автор',
                        'librarian' => 'Бібліотекар',
                        'admin' => 'Адміністратор',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Додати підписку')
                    ->preloadRecordSelect()
                    ->modalHeading('Додати підписку на користувача'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Переглянути профіль'),
                Tables\Actions\DetachAction::make()
                    ->label('Відписатися')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->label('Відписатися від обраних')
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('pivot.created_at', 'desc')
            ->emptyStateHeading('Немає підписок')
            ->emptyStateDescription('Користувач ще ні на кого не підписаний.')
            ->emptyStateActions([
                Tables\Actions\AttachAction::make()
                    ->label('Додати підписку')
                    ->preloadRecordSelect(),
            ]);
    }
}
