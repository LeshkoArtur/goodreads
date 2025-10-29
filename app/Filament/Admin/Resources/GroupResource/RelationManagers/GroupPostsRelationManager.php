<?php

namespace App\Filament\Admin\Resources\GroupResource\RelationManagers;

use App\Enums\PostStatus;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class GroupPostsRelationManager extends RelationManager
{
    protected static string $relationship = 'groupPosts';

    protected static ?string $title = 'Пости групи';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('user.profile_picture')
                    ->label('Автор')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                Tables\Columns\TextColumn::make('user.username')
                    ->label('Користувач')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('content')
                    ->label('Контент')
                    ->searchable()
                    ->limit(100)
                    ->wrap(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Категорія')
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('post_status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (?PostStatus $state) => match ($state) {
                        PostStatus::PUBLISHED => 'success',
                        PostStatus::DRAFT => 'warning',
                        PostStatus::ARCHIVED => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_pinned')
                    ->label('Закріплений')
                    ->boolean()
                    ->trueIcon('heroicon-o-bookmark')
                    ->trueColor('warning')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('comments_count')
                    ->label('Коментарі')
                    ->counts('comments')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('likes_count')
                    ->label('Лайки')
                    ->counts('likes')
                    ->badge()
                    ->color('success')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('post_status')
                    ->label('Статус')
                    ->options(PostStatus::class),
                Tables\Filters\TernaryFilter::make('is_pinned')
                    ->label('Закріплені'),
            ])
            ->actions([
                Tables\Actions\Action::make('pin')
                    ->label('Закріпити')
                    ->icon('heroicon-o-bookmark')
                    ->color('warning')
                    ->visible(fn ($record) => ! $record->is_pinned)
                    ->action(fn ($record) => $record->update(['is_pinned' => true])),
                Tables\Actions\Action::make('unpin')
                    ->label('Відкріпити')
                    ->icon('heroicon-o-bookmark-slash')
                    ->color('gray')
                    ->visible(fn ($record) => $record->is_pinned)
                    ->action(fn ($record) => $record->update(['is_pinned' => false])),
                Tables\Actions\ViewAction::make()
                    ->label('Переглянути'),
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
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Немає постів')
            ->emptyStateDescription('У цій групі ще немає постів.');
    }
}
