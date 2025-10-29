<?php

namespace App\Filament\Admin\Resources\GroupPollResource\Pages;

use App\Actions\GroupPolls\UpdateGroupPoll as UpdateAction;
use App\Data\GroupPoll\GroupPollUpdateData;
use App\Filament\Admin\Resources\GroupPollResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditGroupPoll extends EditRecord
{
    protected static string $resource = GroupPollResource::class;

    protected ?string $heading = 'Редагувати опитування';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = GroupPollUpdateData::fromArray($data);

        return app(UpdateAction::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Опитування оновлено';
    }
}
