<?php

namespace App\Filament\Admin\Resources\NominationEntryResource\Pages;

use App\Filament\Admin\Resources\NominationEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewNominationEntry extends ViewRecord
{
    protected static string $resource = NominationEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
