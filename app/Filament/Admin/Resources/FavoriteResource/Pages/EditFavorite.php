<?php

namespace App\Filament\Admin\Resources\FavoriteResource\Pages;

use App\Actions\Favorites\UpdateFavorite as UpdateAction;
use App\Data\Favorite\FavoriteUpdateData;
use App\Filament\Admin\Resources\FavoriteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditFavorite extends EditRecord
{
    protected static string $resource = FavoriteResource::class;

    protected ?string $heading = 'Редагувати обране';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = FavoriteUpdateData::fromArray($data);

        return app(UpdateAction::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Обране оновлено';
    }
}
