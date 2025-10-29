<?php

namespace App\Filament\Admin\Resources\RatingResource\Pages;

use App\Actions\Ratings\UpdateRating;
use App\Data\Rating\RatingUpdateData;
use App\Filament\Admin\Resources\RatingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditRating extends EditRecord
{
    protected static string $resource = RatingResource::class;

    protected ?string $heading = 'Редагувати рейтинг';

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
        $dto = RatingUpdateData::fromArray($data);

        return app(UpdateRating::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Рейтинг оновлено';
    }
}
