<?php

namespace App\Filament\Admin\Resources\ViewHistoryResource\Pages;

use App\Actions\ViewHistories\UpdateViewHistory as UpdateAction;
use App\Data\ViewHistory\ViewHistoryUpdateData;
use App\Filament\Admin\Resources\ViewHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditViewHistory extends EditRecord
{
    protected static string $resource = ViewHistoryResource::class;

    protected ?string $heading = 'Редагувати запис';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = ViewHistoryUpdateData::fromArray($data);

        return app(UpdateAction::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Запис оновлено';
    }
}
