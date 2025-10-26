<?php

namespace App\Filament\Admin\Resources\ShelfResource\Pages;

use App\DTOs\Shelf\ShelfStoreDTO;
use App\Filament\Admin\Resources\ShelfResource;
use App\Models\Shelf;
use App\Actions\Shelves\CreateShelf as CreateShelfAction;
use Filament\Resources\Pages\CreateRecord;

class CreateShelf extends CreateRecord
{
    protected static string $resource = ShelfResource::class;

    protected function handleRecordCreation(array $data): Shelf
    {
        $dto = ShelfStoreDTO::fromArray($data);

        return CreateShelfAction::run($dto);
    }
}
