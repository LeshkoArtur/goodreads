<?php

namespace App\Filament\Admin\Resources\BookOfferResource\Pages;

use App\Actions\BookOffers\UpdateBookOffer;
use App\DTOs\BookOffer\BookOfferUpdateDTO;
use App\Filament\Admin\Resources\BookOfferResource;
use App\Models\BookOffer;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditBookOffer extends EditRecord
{
    protected static string $resource = BookOfferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(BookOffer|Model $record, array $data): BookOffer
    {
        $dto = BookOfferUpdateDTO::fromArray($data);

        return UpdateBookOffer::run($record, $dto);
    }
}
