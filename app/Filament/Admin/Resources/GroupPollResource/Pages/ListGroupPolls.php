<?php

namespace App\Filament\Admin\Resources\GroupPollResource\Pages;

use App\Filament\Admin\Resources\GroupPollResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGroupPolls extends ListRecords
{
    protected static string $resource = GroupPollResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Створити опитування'),
        ];
    }
}
