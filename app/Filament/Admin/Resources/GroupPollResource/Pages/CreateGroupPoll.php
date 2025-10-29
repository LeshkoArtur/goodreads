<?php

namespace App\Filament\Admin\Resources\GroupPollResource\Pages;

use App\Actions\GroupPolls\CreateGroupPoll as CreateAction;
use App\Data\GroupPoll\GroupPollStoreData;
use App\Filament\Admin\Resources\GroupPollResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateGroupPoll extends CreateRecord
{
    protected static string $resource = GroupPollResource::class;

    protected ?string $heading = 'Створити опитування';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = GroupPollStoreData::fromArray($data);

        return app(CreateAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Опитування створено';
    }
}
