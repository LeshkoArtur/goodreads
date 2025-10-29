<?php

namespace App\Filament\Admin\Resources\ReadingStatResource\Pages;

use App\Filament\Admin\Resources\ReadingStatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReadingStats extends ListRecords
{
    protected static string $resource = ReadingStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Створити статистику'),
        ];
    }
}
