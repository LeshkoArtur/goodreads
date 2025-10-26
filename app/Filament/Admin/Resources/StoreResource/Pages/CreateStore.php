<?php

namespace App\Filament\Admin\Resources\StoreResource\Pages;

use App\DTOs\Store\StoreStoreDTO;
use App\Filament\Admin\Resources\StoreResource;
use App\Models\Store;
use App\Actions\Stores\CreateStore as CreateStoreAction;
use Filament\Resources\Pages\CreateRecord;

class CreateStore extends CreateRecord
{
    protected static string $resource = StoreResource::class;

    protected function handleRecordCreation(array $data): Store
    {
        $dto = StoreStoreDTO::fromArray($data);

        return CreateStoreAction::run($dto);
    }
}
