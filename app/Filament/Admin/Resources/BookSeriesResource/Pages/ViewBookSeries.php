<?php

namespace App\Filament\Admin\Resources\BookSeriesResource\Pages;

use App\Filament\Admin\Resources\BookSeriesResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBookSeries extends ViewRecord
{
    protected static string $resource = BookSeriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Редагувати'),
            Actions\DeleteAction::make()
                ->label('Видалити'),
        ];
    }
}
