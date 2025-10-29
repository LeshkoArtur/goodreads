<?php

namespace App\Filament\Admin\Resources\CollectionResource\Pages;

use App\Actions\Collections\UpdateCollection as UpdateAction;
use App\Data\Collection\CollectionUpdateData;
use App\Filament\Admin\Resources\CollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditCollection extends EditRecord
{
    protected static string $resource = CollectionResource::class;

    protected ?string $heading = 'Редагувати колекцію';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = CollectionUpdateData::fromArray($data);

        return app(UpdateAction::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Колекцію оновлено';
    }
}
