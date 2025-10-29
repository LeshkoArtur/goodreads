<?php

namespace App\Filament\Admin\Resources\NominationResource\Pages;

use App\Filament\Admin\Resources\NominationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewNomination extends ViewRecord
{
    protected static string $resource = NominationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
