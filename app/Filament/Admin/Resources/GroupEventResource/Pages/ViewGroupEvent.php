<?php

namespace App\Filament\Admin\Resources\GroupEventResource\Pages;

use App\Filament\Admin\Resources\GroupEventResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGroupEvent extends ViewRecord
{
    protected static string $resource = GroupEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
