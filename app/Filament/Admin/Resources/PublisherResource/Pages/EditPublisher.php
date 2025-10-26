<?php

namespace App\Filament\Admin\Resources\PublisherResource\Pages;

use App\Actions\Publishers\UpdatePublisher;
use App\DTOs\Publisher\PublisherUpdateDTO;
use App\Filament\Admin\Resources\PublisherResource;
use App\Models\Publisher;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditPublisher extends EditRecord
{
    protected static string $resource = PublisherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Publisher|Model $record, array $data): Publisher
    {
        $dto = PublisherUpdateDTO::fromArray($data);

        return UpdatePublisher::run($record, $dto);
    }
}
