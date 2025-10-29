<?php

namespace App\Filament\Admin\Resources\GroupInvitationResource\Pages;

use App\Actions\GroupInvitations\UpdateGroupInvitation as UpdateAction;
use App\Data\GroupInvitation\GroupInvitationUpdateData;
use App\Filament\Admin\Resources\GroupInvitationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditGroupInvitation extends EditRecord
{
    protected static string $resource = GroupInvitationResource::class;

    protected ?string $heading = 'Редагувати запрошення';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = GroupInvitationUpdateData::fromArray($data);

        return app(UpdateAction::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Запрошення оновлено';
    }
}
