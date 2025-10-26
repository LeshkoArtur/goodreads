<?php

namespace App\Filament\Admin\Resources\GroupEventResource\Pages;

use App\DTOs\GroupEvent\GroupEventStoreDTO;
use App\Filament\Admin\Resources\GroupEventResource;
use App\Models\GroupEvent;
use App\Actions\GroupEvents\CreateGroupEvent as CreateGroupEventAction;
use Filament\Resources\Pages\CreateRecord;

class CreateGroupEvent extends CreateRecord
{
    protected static string $resource = GroupEventResource::class;

    protected function handleRecordCreation(array $data): GroupEvent
    {
        $dto = GroupEventStoreDTO::fromArray($data);

        return CreateGroupEventAction::run($dto);
    }
}
