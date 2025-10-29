<?php

namespace App\Filament\Admin\Resources\StoreResource\Pages;

use App\Actions\Stores\UpdateStore as UpdateAction;
use App\Data\Store\StoreUpdateData;
use App\Filament\Admin\Resources\StoreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditStore extends EditRecord
{
    protected static string $resource = StoreResource::class;

    protected ?string $heading = 'Редагувати магазин';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = StoreUpdateData::fromArray($data);

        return app(UpdateAction::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Магазин оновлено';
    }
}
