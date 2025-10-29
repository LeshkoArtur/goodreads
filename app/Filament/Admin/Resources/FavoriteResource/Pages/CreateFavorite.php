<?php

namespace App\Filament\Admin\Resources\FavoriteResource\Pages;

use App\Actions\Favorites\CreateFavorite as CreateAction;
use App\Data\Favorite\FavoriteStoreData;
use App\Filament\Admin\Resources\FavoriteResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateFavorite extends CreateRecord
{
    protected static string $resource = FavoriteResource::class;

    protected ?string $heading = 'Додати в обране';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = FavoriteStoreData::fromArray($data);

        return app(CreateAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Додано в обране';
    }
}
