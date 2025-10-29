<?php

namespace App\Filament\Admin\Resources\ReportResource\Pages;

use App\Actions\Reports\CreateReport as CreateAction;
use App\Data\Report\ReportStoreData;
use App\Filament\Admin\Resources\ReportResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateReport extends CreateRecord
{
    protected static string $resource = ReportResource::class;

    protected ?string $heading = 'Створити скаргу';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = ReportStoreData::fromArray($data);

        return app(CreateAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Скаргу створено';
    }
}
