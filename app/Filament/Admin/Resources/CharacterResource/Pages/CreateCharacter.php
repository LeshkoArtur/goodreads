<?php

namespace App\Filament\Admin\Resources\CharacterResource\Pages;

use App\Actions\Characters\CreateCharacter as CreateAction;
use App\Data\Character\CharacterStoreData;
use App\Filament\Admin\Resources\CharacterResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateCharacter extends CreateRecord
{
    protected static string $resource = CharacterResource::class;

    protected ?string $heading = 'Створити персонажа';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = CharacterStoreData::fromArray($data);

        return app(CreateAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Персонажа створено';
    }
}
