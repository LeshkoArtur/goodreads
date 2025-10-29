<?php

namespace App\Filament\Admin\Resources\GroupResource\Pages;

use App\Actions\Groups\CreateGroup as CreateGroupAction;
use App\Data\Group\GroupStoreData;
use App\Filament\Admin\Resources\GroupResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateGroup extends CreateRecord
{
    protected static string $resource = GroupResource::class;

    protected ?string $heading = 'Створити групу';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = GroupStoreData::fromArray($data);

        return app(CreateGroupAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Групу створено';
    }
}
