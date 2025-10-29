<?php

namespace App\Filament\Admin\Resources\GroupPollResource\Pages;

use App\Filament\Admin\Resources\GroupPollResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGroupPoll extends ViewRecord
{
    protected static string $resource = GroupPollResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
