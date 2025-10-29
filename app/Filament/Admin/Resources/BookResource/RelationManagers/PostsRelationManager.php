<?php

namespace App\Filament\Admin\Resources\BookResource\RelationManagers;

use App\Enums\PostStatus;
use App\Enums\PostType;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $title = 'Пости';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Обкладинка')
                    ->size(50),
                Tables\Columns\TextColumn::make('title')
                    ->label('Назва')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('user.username')
                    ->label('Автор')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Тип')
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (PostStatus $state) => match ($state) {
                        PostStatus::PUBLISHED => 'success',
                        PostStatus::DRAFT => 'warning',
                        PostStatus::ARCHIVED => 'danger',
                        PostStatus::PENDING => 'warning',
                    }),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Опубліковано')
                    ->dateTime('d.m.Y')
                    ->sortable()
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
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Тип')
                    ->options(PostType::class),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options(PostStatus::class),
            ])
            ->actions([
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
            ->defaultSort('published_at', 'desc')
            ->emptyStateHeading('Немає постів')
            ->emptyStateDescription('Поки що немає постів про цю книгу.');
    }
}
