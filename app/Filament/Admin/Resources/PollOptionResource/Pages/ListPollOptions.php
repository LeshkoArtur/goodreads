<?php

namespace App\Filament\Admin\Resources\PollOptionResource\Pages;

use App\Filament\Admin\Resources\PollOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPollOptions extends ListRecords
{
    protected static string $resource = PollOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Створити варіант'),
        ];
    }
}
