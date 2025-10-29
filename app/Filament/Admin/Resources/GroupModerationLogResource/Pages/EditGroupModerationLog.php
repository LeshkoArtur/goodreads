<?php

namespace App\Filament\Admin\Resources\GroupModerationLogResource\Pages;

use App\Actions\GroupModerationLogs\UpdateGroupModerationLog as UpdateAction;
use App\Data\GroupModerationLog\GroupModerationLogUpdateData;
use App\Filament\Admin\Resources\GroupModerationLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditGroupModerationLog extends EditRecord
{
    protected static string $resource = GroupModerationLogResource::class;

    protected ?string $heading = 'Редагувати лог модерації';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = GroupModerationLogUpdateData::fromArray($data);

        return app(UpdateAction::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Лог модерації оновлено';
    }
}
