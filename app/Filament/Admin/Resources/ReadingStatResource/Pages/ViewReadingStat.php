<?php

namespace App\Filament\Admin\Resources\ReadingStatResource\Pages;

use App\Filament\Admin\Resources\ReadingStatResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewReadingStat extends ViewRecord
{
    protected static string $resource = ReadingStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
