<?php

namespace App\Filament\Admin\Resources\BookSeriesResource\Pages;

use App\Filament\Admin\Resources\BookSeriesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookSeries extends ListRecords
{
    protected static string $resource = BookSeriesResource::class;

    protected ?string $heading = 'Серії книг';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Створити серію'),
        ];
    }
}
