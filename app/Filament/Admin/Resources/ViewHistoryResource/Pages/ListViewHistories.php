<?php

namespace App\Filament\Admin\Resources\ViewHistoryResource\Pages;

use App\Filament\Admin\Resources\ViewHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListViewHistories extends ListRecords
{
    protected static string $resource = ViewHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Створити запис'),
        ];
    }
}
