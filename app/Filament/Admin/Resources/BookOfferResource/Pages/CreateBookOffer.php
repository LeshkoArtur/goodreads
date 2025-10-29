<?php

namespace App\Filament\Admin\Resources\BookOfferResource\Pages;

use App\Actions\BookOffers\CreateBookOffer as CreateAction;
use App\Data\BookOffer\BookOfferStoreData;
use App\Filament\Admin\Resources\BookOfferResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateBookOffer extends CreateRecord
{
    protected static string $resource = BookOfferResource::class;

    protected ?string $heading = 'Створити пропозицію';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = BookOfferStoreData::fromArray($data);

        return app(CreateAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Пропозицію створено';
    }
}
