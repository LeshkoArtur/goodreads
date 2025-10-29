<?php

namespace App\Filament\Admin\Resources\ReportResource\Pages;

use App\Filament\Admin\Resources\ReportResource;
use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewReport extends ViewRecord
{
    protected static string $resource = ReportResource::class;

    protected ?string $heading = 'Перегляд скарги';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->label('Редагувати'),
            Actions\DeleteAction::make()->label('Видалити'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Інформація про скаргу')
                    ->schema([
                        Infolists\Components\TextEntry::make('user.username')
                            ->label('Хто подав скаргу'),
                        Infolists\Components\TextEntry::make('user.email')
                            ->label('Email користувача')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('type')
                            ->label('Тип скарги')
                            ->badge(),
                        Infolists\Components\TextEntry::make('status')
                            ->label('Статус обробки')
                            ->badge(),
                    ])->columns(2),

                Infolists\Components\Section::make('Об\'єкт скарги')
                    ->schema([
                        Infolists\Components\TextEntry::make('reportable_type')
                            ->label('Тип об\'єкту')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'App\\Models\\User' => 'Користувач',
                                'App\\Models\\Book' => 'Книга',
                                'App\\Models\\Comment' => 'Коментар',
                                'App\\Models\\Post' => 'Пост',
                                'App\\Models\\Quote' => 'Цитата',
                                default => class_basename($state),
                            }
                            ),
                        Infolists\Components\TextEntry::make('reportable_id')
                            ->label('ID об\'єкту')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('description')
                            ->label('Опис проблеми')
                            ->columnSpanFull()
                            ->markdown()
                            ->placeholder('Опис відсутній'),
                    ])->columns(2),

                Infolists\Components\Section::make('Метадані')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Створено')
                            ->dateTime('d.m.Y H:i:s'),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Оновлено')
                            ->dateTime('d.m.Y H:i:s')
                            ->placeholder('Не оновлювалось'),
                    ])->columns(2)->collapsed(),
            ]);
    }
}
