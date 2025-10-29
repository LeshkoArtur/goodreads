<?php

namespace App\Filament\Admin\Resources\NominationResource\Pages;

use App\Filament\Admin\Resources\NominationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNominations extends ListRecords
{
    protected static string $resource = NominationResource::class;

    protected ?string $heading = 'Номінації';

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()->label('Створити номінацію')];
    }
}
