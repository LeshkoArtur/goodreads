<?php

namespace App\Filament\Admin\Resources\BookSeriesResource\Pages;

use App\Actions\BookSeries\CreateBookSeries as CreateBookSeriesAction;
use App\Data\BookSeries\BookSeriesStoreData;
use App\Filament\Admin\Resources\BookSeriesResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateBookSeries extends CreateRecord
{
    protected static string $resource = BookSeriesResource::class;

    protected ?string $heading = 'Створити серію книг';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = BookSeriesStoreData::fromArray($data);

        return app(CreateBookSeriesAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Серію створено';
    }
}
