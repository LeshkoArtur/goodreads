<?php

namespace App\Filament\Admin\Resources\BookResource\Pages;

use App\Actions\Books\CreateBook as CreateBookAction;
use App\Data\Book\BookStoreData;
use App\Filament\Admin\Resources\BookResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateBook extends CreateRecord
{
    protected static string $resource = BookResource::class;

    protected ?string $heading = 'Створити книгу';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = BookStoreData::fromArray($data);

        return app(CreateBookAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Книгу створено';
    }
}
