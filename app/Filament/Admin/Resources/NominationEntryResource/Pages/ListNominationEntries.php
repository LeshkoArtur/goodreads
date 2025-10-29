<?php

namespace App\Filament\Admin\Resources\NominationEntryResource\Pages;

use App\Filament\Admin\Resources\NominationEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNominationEntries extends ListRecords
{
    protected static string $resource = NominationEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Створити запис номінації'),
        ];
    }
}
