<?php

namespace App\Filament\Admin\Resources\StoreResource\Pages;

use App\Actions\Stores\CreateStore as CreateAction;
use App\Data\Store\StoreStoreData;
use App\Filament\Admin\Resources\StoreResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateStore extends CreateRecord
{
    protected static string $resource = StoreResource::class;

    protected ?string $heading = 'Створити магазин';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = StoreStoreData::fromArray($data);

        return app(CreateAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Магазин створено';
    }
}
