<?php

namespace App\Filament\Admin\Resources\ViewHistoryResource\Pages;

use App\Actions\ViewHistories\CreateViewHistory as CreateAction;
use App\Data\ViewHistory\ViewHistoryStoreData;
use App\Filament\Admin\Resources\ViewHistoryResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateViewHistory extends CreateRecord
{
    protected static string $resource = ViewHistoryResource::class;

    protected ?string $heading = 'Створити запис';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = ViewHistoryStoreData::fromArray($data);

        return app(CreateAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Запис створено';
    }
}
