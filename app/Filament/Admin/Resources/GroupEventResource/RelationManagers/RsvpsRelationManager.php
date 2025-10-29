<?php

namespace App\Filament\Admin\Resources\GroupEventResource\RelationManagers;

use App\Enums\EventResponse;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class RsvpsRelationManager extends RelationManager
{
    protected static string $relationship = 'rsvps';

    protected static ?string $title = 'Відповіді на подію';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('user.profile_picture')
                    ->label('Користувач')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                Tables\Columns\TextColumn::make('user.username')
                    ->label('Користувач')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('response')
                    ->label('Відповідь')
                    ->badge()
                    ->color(fn (?EventResponse $state) => match ($state) {
                        EventResponse::GOING => 'success',
                        EventResponse::MAYBE => 'warning',
                        EventResponse::NOT_GOING => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Відповів')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('response')
                    ->label('Відповідь')
                    ->options(EventResponse::class),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Переглянути'),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Немає відповідей')
            ->emptyStateDescription('Поки що ніхто не відповів на цю подію.');
    }
}
