<?php

namespace App\Filament\Admin\Resources\TagResource\Pages;

use App\Actions\Tags\CreateTag as CreateTagAction;
use App\Data\Tag\TagStoreData;
use App\Filament\Admin\Resources\TagResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTag extends CreateRecord
{
    protected static string $resource = TagResource::class;

    protected ?string $heading = 'Створити тег';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = TagStoreData::fromArray($data);

        return app(CreateTagAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Тег створено';
    }
}
