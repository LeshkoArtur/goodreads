<?php

namespace App\Filament\Admin\Resources\BookOfferResource\Pages;

use App\Filament\Admin\Resources\BookOfferResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookOffers extends ListRecords
{
    protected static string $resource = BookOfferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Створити пропозицію'),
        ];
    }
}
