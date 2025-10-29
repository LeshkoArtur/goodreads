<?php

namespace App\Filament\Admin\Resources\AuthorQuestionResource\RelationManagers;

use App\Enums\AnswerStatus;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AnswersRelationManager extends RelationManager
{
    protected static string $relationship = 'answers';

    protected static ?string $title = 'Відповіді';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('user.profile_picture')
                    ->label('Автор відповіді')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                Tables\Columns\TextColumn::make('user.username')
                    ->label('Відповів')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('content')
                    ->label('Відповідь')
                    ->searchable()
                    ->limit(120)
                    ->wrap(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (?AnswerStatus $state) => match ($state) {
                        AnswerStatus::PENDING => 'warning',
                        AnswerStatus::APPROVED => 'success',
                        AnswerStatus::REJECTED => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options(AnswerStatus::class),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Переглянути'),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Немає відповідей')
            ->emptyStateDescription('На це питання ще не було відповідей.');
    }
}
