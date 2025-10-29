<?php

namespace App\Filament\Admin\Resources\EventRsvpResource\Pages;

use App\Filament\Admin\Resources\EventRsvpResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEventRsvp extends ViewRecord
{
    protected static string $resource = EventRsvpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
