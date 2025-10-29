<?php

namespace App\Filament\Admin\Resources\AuthorResource\Pages;

use App\Actions\Authors\CreateAuthor as CreateAuthorAction;
use App\Data\Author\AuthorStoreData;
use App\Filament\Admin\Resources\AuthorResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateAuthor extends CreateRecord
{
    protected static string $resource = AuthorResource::class;

    protected ?string $heading = 'Створити автора';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = AuthorStoreData::fromArray($data);

        return app(CreateAuthorAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Автора створено';
    }
}
