<?php

namespace App\Filament\Admin\Resources\AwardResource\Pages;

use App\Actions\Awards\CreateAward as CreateAwardAction;
use App\Data\Award\AwardStoreData;
use App\Filament\Admin\Resources\AwardResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateAward extends CreateRecord
{
    protected static string $resource = AwardResource::class;

    protected ?string $heading = 'Створити нагороду';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = AwardStoreData::fromArray($data);

        return app(CreateAwardAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Нагороду створено';
    }
}
