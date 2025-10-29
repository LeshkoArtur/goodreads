<?php

namespace App\Filament\Admin\Resources\EventRsvpResource\Pages;

use App\Filament\Admin\Resources\EventRsvpResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventRsvps extends ListRecords
{
    protected static string $resource = EventRsvpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Створити відповідь'),
        ];
    }
}
