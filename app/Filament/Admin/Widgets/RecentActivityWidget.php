<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Rating;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentActivityWidget extends BaseWidget
{
    protected static ?int $sort = 6;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = '🔥 Остання активність';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Rating::query()
                    ->with(['user', 'book'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('user.avatar')
                    ->label('Користувач')
                    ->disk('public')
                    ->size(40)
                    ->circular()
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name='.urlencode($record->user->username)),
                Tables\Columns\TextColumn::make('user.username')
                    ->label('Ім\'я')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('book.title')
                    ->label('Книга')
                    ->limit(40)
                    ->searchable()
                    ->description(fn ($record) => $record->book->authors->pluck('name')->join(', ')),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Оцінка')
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state >= 4 => 'success',
                        $state >= 3 => 'warning',
                        default => 'danger',
                    })
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', $state)),
                Tables\Columns\TextColumn::make('review')
                    ->label('Відгук')
                    ->limit(80)
                    ->toggleable()
                    ->wrap()
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Час')
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Переглянути')
                    ->icon('heroicon-m-eye'),
            ])
            ->paginated(false);
    }
}
