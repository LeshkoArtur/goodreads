<?php

namespace App\Filament\Admin\Resources\NominationEntryResource\Pages;

use App\Actions\NominationEntries\UpdateNominationEntry as UpdateAction;
use App\Data\NominationEntry\NominationEntryUpdateData;
use App\Filament\Admin\Resources\NominationEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditNominationEntry extends EditRecord
{
    protected static string $resource = NominationEntryResource::class;

    protected ?string $heading = 'Редагувати запис номінації';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = NominationEntryUpdateData::fromArray($data);

        return app(UpdateAction::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Запис номінації оновлено';
    }
}
