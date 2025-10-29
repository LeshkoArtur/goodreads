<?php

namespace App\Filament\Admin\Resources\EventRsvpResource\Pages;

use App\Actions\EventRsvps\CreateEventRsvp as CreateAction;
use App\Data\EventRsvp\EventRsvpStoreData;
use App\Filament\Admin\Resources\EventRsvpResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateEventRsvp extends CreateRecord
{
    protected static string $resource = EventRsvpResource::class;

    protected ?string $heading = 'Створити відповідь на подію';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = EventRsvpStoreData::fromArray($data);

        return app(CreateAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Відповідь на подію створено';
    }
}
