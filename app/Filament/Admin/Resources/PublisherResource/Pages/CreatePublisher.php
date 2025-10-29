<?php

namespace App\Filament\Admin\Resources\PublisherResource\Pages;

use App\Actions\Publishers\CreatePublisher as CreatePublisherAction;
use App\Data\Publisher\PublisherStoreData;
use App\Filament\Admin\Resources\PublisherResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePublisher extends CreateRecord
{
    protected static string $resource = PublisherResource::class;

    protected ?string $heading = 'Створити видавництво';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = PublisherStoreData::fromArray($data);

        return app(CreatePublisherAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Видавництво створено';
    }
}
