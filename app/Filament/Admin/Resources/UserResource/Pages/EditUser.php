<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Actions\Users\UpdateUser;
use App\DTOs\User\UserUpdateDTO;
use App\Filament\Admin\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(User|Model $record, array $data): User
    {
        $dto = UserUpdateDTO::fromArray($data);

        return UpdateUser::run($record, $dto);
    }
}
