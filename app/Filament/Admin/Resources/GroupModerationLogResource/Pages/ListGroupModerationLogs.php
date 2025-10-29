<?php

namespace App\Filament\Admin\Resources\GroupModerationLogResource\Pages;

use App\Filament\Admin\Resources\GroupModerationLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGroupModerationLogs extends ListRecords
{
    protected static string $resource = GroupModerationLogResource::class;

    protected ?string $heading = 'Логи модерації';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Створити лог')->icon('heroicon-o-plus'),
        ];
    }
}
