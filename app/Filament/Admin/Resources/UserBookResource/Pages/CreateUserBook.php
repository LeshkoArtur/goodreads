<?php

namespace App\Filament\Admin\Resources\UserBookResource\Pages;

use App\Actions\UserBooks\CreateUserBook as CreateUserBookAction;
use App\Data\UserBook\UserBookStoreData;
use App\Filament\Admin\Resources\UserBookResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUserBook extends CreateRecord
{
    protected static string $resource = UserBookResource::class;

    protected ?string $heading = 'Додати книгу користувачу';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = UserBookStoreData::fromArray($data);

        return app(CreateUserBookAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Книгу додано';
    }
}
