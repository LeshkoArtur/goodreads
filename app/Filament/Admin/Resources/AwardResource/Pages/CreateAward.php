<?php

namespace App\Filament\Admin\Resources\AwardResource\Pages;

use App\DTOs\Award\AwardStoreDTO;
use App\Filament\Admin\Resources\AwardResource;
use App\Models\Award;
use App\Actions\Awards\CreateAward as CreateAwardAction;
use Filament\Resources\Pages\CreateRecord;

class CreateAward extends CreateRecord
{
    protected static string $resource = AwardResource::class;

    protected function handleRecordCreation(array $data): Award
    {
        $dto = AwardStoreDTO::fromArray($data);

        return CreateAwardAction::run($dto);
    }
}
