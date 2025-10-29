<?php

namespace App\Filament\Admin\Resources\BookOfferResource\Pages;

use App\Actions\BookOffers\UpdateBookOffer as UpdateAction;
use App\Data\BookOffer\BookOfferUpdateData;
use App\Filament\Admin\Resources\BookOfferResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditBookOffer extends EditRecord
{
    protected static string $resource = BookOfferResource::class;

    protected ?string $heading = 'Редагувати пропозицію';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = BookOfferUpdateData::fromArray($data);

        return app(UpdateAction::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Пропозицію оновлено';
    }
}
