<?php

namespace App\Filament\Admin\Resources\GroupModerationLogResource\Pages;

use App\Filament\Admin\Resources\GroupModerationLogResource;
use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewGroupModerationLog extends ViewRecord
{
    protected static string $resource = GroupModerationLogResource::class;

    protected ?string $heading = 'Перегляд логу модерації';

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
                Infolists\Components\Section::make('Інформація про модерацію')
                    ->schema([
                        Infolists\Components\TextEntry::make('group.name')
                            ->label('Група')
                            ->badge()
                            ->color('info'),
                        Infolists\Components\TextEntry::make('moderator.username')
                            ->label('Модератор'),
                        Infolists\Components\TextEntry::make('action')
                            ->label('Дія')
                            ->badge(),
                    ])->columns(3),

                Infolists\Components\Section::make('Ціль модерації')
                    ->schema([
                        Infolists\Components\TextEntry::make('targetable_type')
                            ->label('Тип цілі')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'App\\Models\\GroupPost' => 'Пост групи',
                                'App\\Models\\Comment' => 'Коментар',
                                default => class_basename($state),
                            }
                            ),
                        Infolists\Components\TextEntry::make('targetable_id')
                            ->label('ID цілі')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('description')
                            ->label('Опис дії')
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
