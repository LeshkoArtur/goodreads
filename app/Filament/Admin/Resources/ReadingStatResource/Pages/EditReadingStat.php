<?php

namespace App\Filament\Admin\Resources\ReadingStatResource\Pages;

use App\Actions\ReadingStats\UpdateReadingStat as UpdateAction;
use App\Data\ReadingStat\ReadingStatUpdateData;
use App\Filament\Admin\Resources\ReadingStatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditReadingStat extends EditRecord
{
    protected static string $resource = ReadingStatResource::class;

    protected ?string $heading = 'Редагувати статистику';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = ReadingStatUpdateData::fromArray($data);

        return app(UpdateAction::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Статистику оновлено';
    }
}
