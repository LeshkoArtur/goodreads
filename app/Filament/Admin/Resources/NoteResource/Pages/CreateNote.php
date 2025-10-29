<?php

namespace App\Filament\Admin\Resources\NoteResource\Pages;

use App\Actions\Notes\CreateNote as CreateAction;
use App\Data\Note\NoteStoreData;
use App\Filament\Admin\Resources\NoteResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateNote extends CreateRecord
{
    protected static string $resource = NoteResource::class;

    protected ?string $heading = 'Створити нотатку';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = NoteStoreData::fromArray($data);

        return app(CreateAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Нотатку створено';
    }
}
