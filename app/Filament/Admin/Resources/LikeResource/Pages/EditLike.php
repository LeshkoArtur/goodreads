<?php

namespace App\Filament\Admin\Resources\LikeResource\Pages;

use App\Actions\Likes\UpdateLike as UpdateAction;
use App\Data\Like\LikeUpdateData;
use App\Filament\Admin\Resources\LikeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditLike extends EditRecord
{
    protected static string $resource = LikeResource::class;

    protected ?string $heading = 'Редагувати лайк';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = LikeUpdateData::fromArray($data);

        return app(UpdateAction::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Лайк оновлено';
    }
}
