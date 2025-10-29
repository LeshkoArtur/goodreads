<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Actions\Users\CreateUser as CreateUserAction;
use App\Data\User\UserStoreData;
use App\Filament\Admin\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected ?string $heading = 'Створити користувача';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = UserStoreData::fromArray($data);

        return app(CreateUserAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Користувача створено';
    }
}
