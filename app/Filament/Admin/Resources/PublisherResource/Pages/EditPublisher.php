<?php

namespace App\Filament\Admin\Resources\PublisherResource\Pages;

use App\Actions\Publishers\UpdatePublisher;
use App\Data\Publisher\PublisherUpdateData;
use App\Filament\Admin\Resources\PublisherResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditPublisher extends EditRecord
{
    protected static string $resource = PublisherResource::class;

    protected ?string $heading = 'Редагувати видавництво';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('Переглянути'),
            Actions\DeleteAction::make()
                ->label('Видалити'),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = PublisherUpdateData::fromArray($data);

        return app(UpdatePublisher::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Видавництво оновлено';
    }
}
