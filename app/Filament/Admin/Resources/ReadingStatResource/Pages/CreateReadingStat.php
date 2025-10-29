<?php

namespace App\Filament\Admin\Resources\ReadingStatResource\Pages;

use App\Actions\ReadingStats\CreateReadingStat as CreateAction;
use App\Data\ReadingStat\ReadingStatStoreData;
use App\Filament\Admin\Resources\ReadingStatResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateReadingStat extends CreateRecord
{
    protected static string $resource = ReadingStatResource::class;

    protected ?string $heading = 'Створити статистику';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = ReadingStatStoreData::fromArray($data);

        return app(CreateAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Статистику створено';
    }
}
