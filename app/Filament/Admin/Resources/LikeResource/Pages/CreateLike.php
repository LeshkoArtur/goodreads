<?php

namespace App\Filament\Admin\Resources\LikeResource\Pages;

use App\Actions\Likes\CreateLike as CreateAction;
use App\Data\Like\LikeStoreData;
use App\Filament\Admin\Resources\LikeResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateLike extends CreateRecord
{
    protected static string $resource = LikeResource::class;

    protected ?string $heading = 'Поставити лайк';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = LikeStoreData::fromArray($data);

        return app(CreateAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Лайк поставлено';
    }
}
