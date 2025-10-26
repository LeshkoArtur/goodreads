<?php

namespace App\Filament\Admin\Resources\GroupResource\Pages;

use App\DTOs\Group\GroupStoreDTO;
use App\Filament\Admin\Resources\GroupResource;
use App\Models\Group;
use App\Actions\Groups\CreateGroup as CreateGroupAction;
use Filament\Resources\Pages\CreateRecord;

class CreateGroup extends CreateRecord
{
    protected static string $resource = GroupResource::class;

    protected function handleRecordCreation(array $data): Group
    {
        $dto = GroupStoreDTO::fromArray($data);

        return CreateGroupAction::run($dto);
    }
}
