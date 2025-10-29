<?php

namespace App\Filament\Admin\Resources\PollOptionResource\Pages;

use App\Actions\PollOptions\CreatePollOption as CreateAction;
use App\Data\PollOption\PollOptionStoreData;
use App\Filament\Admin\Resources\PollOptionResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePollOption extends CreateRecord
{
    protected static string $resource = PollOptionResource::class;

    protected ?string $heading = 'Створити варіант';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = PollOptionStoreData::fromArray($data);

        return app(CreateAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Варіант створено';
    }
}
