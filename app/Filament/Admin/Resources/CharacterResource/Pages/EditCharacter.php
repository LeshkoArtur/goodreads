<?php

namespace App\Filament\Admin\Resources\CharacterResource\Pages;

use App\Actions\Characters\UpdateCharacter as UpdateAction;
use App\Data\Character\CharacterUpdateData;
use App\Filament\Admin\Resources\CharacterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditCharacter extends EditRecord
{
    protected static string $resource = CharacterResource::class;

    protected ?string $heading = 'Редагувати персонажа';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = CharacterUpdateData::fromArray($data);

        return app(UpdateAction::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Персонажа оновлено';
    }
}
