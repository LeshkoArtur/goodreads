<?php

namespace App\Filament\Admin\Resources\RatingResource\Pages;

use App\Actions\Ratings\CreateRating as CreateRatingAction;
use App\Data\Rating\RatingStoreData;
use App\Filament\Admin\Resources\RatingResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateRating extends CreateRecord
{
    protected static string $resource = RatingResource::class;

    protected ?string $heading = 'Створити рейтинг';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = RatingStoreData::fromArray($data);

        return app(CreateRatingAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Рейтинг створено';
    }
}
