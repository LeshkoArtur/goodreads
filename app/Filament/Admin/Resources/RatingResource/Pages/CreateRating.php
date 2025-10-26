<?php

namespace App\Filament\Admin\Resources\RatingResource\Pages;

use App\DTOs\Rating\RatingStoreDTO;
use App\Filament\Admin\Resources\RatingResource;
use App\Models\Rating;
use App\Actions\Ratings\CreateRating as CreateRatingAction;
use Filament\Resources\Pages\CreateRecord;

class CreateRating extends CreateRecord
{
    protected static string $resource = RatingResource::class;

    protected function handleRecordCreation(array $data): Rating
    {
        $dto = RatingStoreDTO::fromArray($data);

        return CreateRatingAction::run($dto);
    }
}
