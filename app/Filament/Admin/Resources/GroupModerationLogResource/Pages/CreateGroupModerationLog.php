<?php

namespace App\Filament\Admin\Resources\GroupModerationLogResource\Pages;

use App\Actions\GroupModerationLogs\CreateGroupModerationLog as CreateAction;
use App\Data\GroupModerationLog\GroupModerationLogStoreData;
use App\Filament\Admin\Resources\GroupModerationLogResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateGroupModerationLog extends CreateRecord
{
    protected static string $resource = GroupModerationLogResource::class;

    protected ?string $heading = 'Створити лог модерації';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = GroupModerationLogStoreData::fromArray($data);

        return app(CreateAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Лог модерації створено';
    }
}
