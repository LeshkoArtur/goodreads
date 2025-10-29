<?php

namespace App\Filament\Admin\Resources\CollectionResource\Pages;

use App\Filament\Admin\Resources\CollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCollection extends ViewRecord
{
    protected static string $resource = CollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
