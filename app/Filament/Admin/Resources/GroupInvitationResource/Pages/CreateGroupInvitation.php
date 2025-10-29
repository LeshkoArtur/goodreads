<?php

namespace App\Filament\Admin\Resources\GroupInvitationResource\Pages;

use App\Actions\GroupInvitations\CreateGroupInvitation as CreateAction;
use App\Data\GroupInvitation\GroupInvitationStoreData;
use App\Filament\Admin\Resources\GroupInvitationResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateGroupInvitation extends CreateRecord
{
    protected static string $resource = GroupInvitationResource::class;

    protected ?string $heading = 'Створити запрошення';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = GroupInvitationStoreData::fromArray($data);

        return app(CreateAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Запрошення створено';
    }
}
