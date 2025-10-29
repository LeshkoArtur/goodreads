<?php

namespace App\Filament\Admin\Resources\ViewHistoryResource\Pages;

use App\Filament\Admin\Resources\ViewHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewViewHistory extends ViewRecord
{
    protected static string $resource = ViewHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
