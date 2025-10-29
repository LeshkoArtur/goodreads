<?php

namespace App\Filament\Admin\Resources\ShelfResource\Pages;

use App\Actions\Shelves\CreateShelf as CreateShelfAction;
use App\Data\Shelf\ShelfStoreData;
use App\Filament\Admin\Resources\ShelfResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateShelf extends CreateRecord
{
    protected static string $resource = ShelfResource::class;

    protected ?string $heading = 'Створити полицю';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = ShelfStoreData::fromArray($data);

        return app(CreateShelfAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Полицю створено';
    }
}
