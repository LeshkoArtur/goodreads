<?php

namespace App\Filament\Admin\Resources\BookOfferResource\Pages;

use App\Filament\Admin\Resources\BookOfferResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookOffer extends EditRecord
{
    protected static string $resource = BookOfferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
