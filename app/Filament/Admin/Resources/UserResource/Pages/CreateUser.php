<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\DTOs\User\UserStoreDTO;
use App\Filament\Admin\Resources\UserResource;
use App\Models\User;
use App\Actions\Users\CreateUser as CreateUserAction;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): User
    {
        $dto = UserStoreDTO::fromArray($data);

        return CreateUserAction::run($dto);
    }
}
