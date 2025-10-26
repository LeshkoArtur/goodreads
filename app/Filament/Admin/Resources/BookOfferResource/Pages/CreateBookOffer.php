<?php

namespace App\Filament\Admin\Resources\BookOfferResource\Pages;

use App\DTOs\BookOffer\BookOfferStoreDTO;
use App\Filament\Admin\Resources\BookOfferResource;
use App\Models\BookOffer;
use App\Actions\BookOffers\CreateBookOffer as CreateBookOfferAction;
use Filament\Resources\Pages\CreateRecord;

class CreateBookOffer extends CreateRecord
{
    protected static string $resource = BookOfferResource::class;

    protected function handleRecordCreation(array $data): BookOffer
    {
        $dto = BookOfferStoreDTO::fromArray($data);

        return CreateBookOfferAction::run($dto);
    }
}
