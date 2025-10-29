<?php

namespace App\Filament\Admin\Resources\NoteResource\Pages;

use App\Actions\Notes\UpdateNote as UpdateAction;
use App\Data\Note\NoteUpdateData;
use App\Filament\Admin\Resources\NoteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditNote extends EditRecord
{
    protected static string $resource = NoteResource::class;

    protected ?string $heading = 'Редагувати нотатку';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = NoteUpdateData::fromArray($data);

        return app(UpdateAction::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Нотатку оновлено';
    }
}
