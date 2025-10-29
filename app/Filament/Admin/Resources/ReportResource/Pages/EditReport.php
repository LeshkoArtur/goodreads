<?php

namespace App\Filament\Admin\Resources\ReportResource\Pages;

use App\Actions\Reports\UpdateReport as UpdateAction;
use App\Data\Report\ReportUpdateData;
use App\Filament\Admin\Resources\ReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditReport extends EditRecord
{
    protected static string $resource = ReportResource::class;

    protected ?string $heading = 'Редагувати скаргу';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = ReportUpdateData::fromArray($data);

        return app(UpdateAction::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Скаргу оновлено';
    }
}
