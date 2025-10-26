<?php

namespace App\Filament\Admin\Resources\RatingResource\Pages;

use App\Actions\Ratings\UpdateRating;
use App\DTOs\Rating\RatingUpdateDTO;
use App\Filament\Admin\Resources\RatingResource;
use App\Models\Rating;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditRating extends EditRecord
{
    protected static string $resource = RatingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Rating|Model $record, array $data): Rating
    {
        $dto = RatingUpdateDTO::fromArray($data);

        return UpdateRating::run($record, $dto);
    }
}
