<?php

namespace App\Filament\Admin\Resources\AwardResource\Pages;

use App\Actions\Awards\UpdateAward;
use App\Data\Award\AwardUpdateData;
use App\Filament\Admin\Resources\AwardResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditAward extends EditRecord
{
    protected static string $resource = AwardResource::class;

    protected ?string $heading = 'Редагувати нагороду';

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
        $dto = AwardUpdateData::fromArray($data);

        return app(UpdateAward::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Нагороду оновлено';
    }
}
