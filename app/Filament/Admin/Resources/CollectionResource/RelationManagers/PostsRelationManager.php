<?php

namespace App\Filament\Admin\Resources\CollectionResource\RelationManagers;

use App\Enums\PostStatus;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $title = 'Пости про колекцію';

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
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (?PostStatus $state) => match ($state) {
                        PostStatus::PUBLISHED => 'success',
                        PostStatus::DRAFT => 'warning',
                        PostStatus::ARCHIVED => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Опубліковано')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Переглянути'),
            ])
            ->defaultSort('published_at', 'desc')
            ->emptyStateHeading('Немає постів')
            ->emptyStateDescription('Поки що немає постів про цю колекцію.');
    }
}
