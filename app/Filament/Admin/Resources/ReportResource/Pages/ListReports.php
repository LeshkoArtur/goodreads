<?php

namespace App\Filament\Admin\Resources\ReportResource\Pages;

use App\Filament\Admin\Resources\ReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReports extends ListRecords
{
    protected static string $resource = ReportResource::class;

    protected ?string $heading = 'Скарги';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Створити скаргу')->icon('heroicon-o-plus'),
        ];
    }
}
