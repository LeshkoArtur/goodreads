<?php

namespace App\Filament\Admin\Resources\NominationEntryResource\Pages;

use App\Actions\NominationEntries\CreateNominationEntry as CreateAction;
use App\Data\NominationEntry\NominationEntryStoreData;
use App\Filament\Admin\Resources\NominationEntryResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateNominationEntry extends CreateRecord
{
    protected static string $resource = NominationEntryResource::class;

    protected ?string $heading = 'Створити запис номінації';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = NominationEntryStoreData::fromArray($data);

        return app(CreateAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Запис номінації створено';
    }
}
