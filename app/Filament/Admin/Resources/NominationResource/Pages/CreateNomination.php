<?php

namespace App\Filament\Admin\Resources\NominationResource\Pages;

use App\Actions\Nominations\CreateNomination as CreateNominationAction;
use App\Data\Nomination\NominationStoreData;
use App\Filament\Admin\Resources\NominationResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateNomination extends CreateRecord
{
    protected static string $resource = NominationResource::class;

    protected ?string $heading = 'Створити номінацію';

    protected function handleRecordCreation(array $data): Model
    {
        return app(CreateNominationAction::class)->handle(NominationStoreData::fromArray($data));
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Номінацію створено';
    }
}
