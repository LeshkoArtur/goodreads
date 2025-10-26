<?php

namespace App\Filament\Admin\Resources\PublisherResource\Pages;

use App\DTOs\Publisher\PublisherStoreDTO;
use App\Filament\Admin\Resources\PublisherResource;
use App\Models\Publisher;
use App\Actions\Publishers\CreatePublisher as CreatePublisherAction;
use Filament\Resources\Pages\CreateRecord;

class CreatePublisher extends CreateRecord
{
    protected static string $resource = PublisherResource::class;

    protected function handleRecordCreation(array $data): Publisher
    {
        $dto = PublisherStoreDTO::fromArray($data);

        return CreatePublisherAction::run($dto);
    }
}
