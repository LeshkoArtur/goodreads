<?php

namespace App\Filament\Admin\Resources\NominationResource\Pages;

use App\Actions\Nominations\UpdateNomination;
use App\Data\Nomination\NominationUpdateData;
use App\Filament\Admin\Resources\NominationResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditNomination extends EditRecord
{
    protected static string $resource = NominationResource::class;

    protected ?string $heading = 'Редагувати номінацію';

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return app(UpdateNomination::class)->handle($record, NominationUpdateData::fromArray($data));
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Номінацію оновлено';
    }
}
