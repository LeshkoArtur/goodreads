<?php

namespace App\Filament\Admin\Resources\CollectionResource\Pages;

use App\Actions\Collections\CreateCollection as CreateAction;
use App\Data\Collection\CollectionStoreData;
use App\Filament\Admin\Resources\CollectionResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateCollection extends CreateRecord
{
    protected static string $resource = CollectionResource::class;

    protected ?string $heading = 'Створити колекцію';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = CollectionStoreData::fromArray($data);

        return app(CreateAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Колекцію створено';
    }
}
