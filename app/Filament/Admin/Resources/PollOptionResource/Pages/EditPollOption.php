<?php

namespace App\Filament\Admin\Resources\PollOptionResource\Pages;

use App\Actions\PollOptions\UpdatePollOption as UpdateAction;
use App\Data\PollOption\PollOptionUpdateData;
use App\Filament\Admin\Resources\PollOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditPollOption extends EditRecord
{
    protected static string $resource = PollOptionResource::class;

    protected ?string $heading = 'Редагувати варіант';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = PollOptionUpdateData::fromArray($data);

        return app(UpdateAction::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Варіант оновлено';
    }
}
