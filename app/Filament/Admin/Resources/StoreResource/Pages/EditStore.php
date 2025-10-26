<?php

namespace App\Filament\Admin\Resources\StoreResource\Pages;

use App\Actions\Stores\UpdateStore;
use App\DTOs\Store\StoreUpdateDTO;
use App\Filament\Admin\Resources\StoreResource;
use App\Models\Store;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditStore extends EditRecord
{
    protected static string $resource = StoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Store|Model $record, array $data): Store
    {
        $dto = StoreUpdateDTO::fromArray($data);

        return UpdateStore::run($record, $dto);
    }
}
