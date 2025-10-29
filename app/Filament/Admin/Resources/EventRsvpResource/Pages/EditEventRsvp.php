<?php

namespace App\Filament\Admin\Resources\EventRsvpResource\Pages;

use App\Actions\EventRsvps\UpdateEventRsvp as UpdateAction;
use App\Data\EventRsvp\EventRsvpUpdateData;
use App\Filament\Admin\Resources\EventRsvpResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditEventRsvp extends EditRecord
{
    protected static string $resource = EventRsvpResource::class;

    protected ?string $heading = 'Редагувати відповідь на подію';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = EventRsvpUpdateData::fromArray($data);

        return app(UpdateAction::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Відповідь на подію оновлено';
    }
}
