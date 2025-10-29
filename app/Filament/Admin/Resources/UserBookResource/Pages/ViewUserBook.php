<?php

namespace App\Filament\Admin\Resources\UserBookResource\Pages;

use App\Filament\Admin\Resources\UserBookResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUserBook extends ViewRecord
{
    protected static string $resource = UserBookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
