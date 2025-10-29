<?php

namespace App\Filament\Admin\Resources\PollOptionResource\Pages;

use App\Filament\Admin\Resources\PollOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPollOption extends ViewRecord
{
    protected static string $resource = PollOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
