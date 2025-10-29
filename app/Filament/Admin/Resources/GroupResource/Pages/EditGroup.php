<?php

namespace App\Filament\Admin\Resources\GroupResource\Pages;

use App\Actions\Groups\UpdateGroup;
use App\Data\Group\GroupUpdateData;
use App\Filament\Admin\Resources\GroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditGroup extends EditRecord
{
    protected static string $resource = GroupResource::class;

    protected ?string $heading = 'Редагувати групу';

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
        $dto = GroupUpdateData::fromArray($data);

        return app(UpdateGroup::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Групу оновлено';
    }
}
