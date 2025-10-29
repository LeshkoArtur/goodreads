<?php

namespace App\Filament\Admin\Resources\GroupEventResource\Pages;

use App\Actions\GroupEvents\UpdateGroupEvent;
use App\Data\GroupEvent\GroupEventUpdateData;
use App\Filament\Admin\Resources\GroupEventResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditGroupEvent extends EditRecord
{
    protected static string $resource = GroupEventResource::class;

    protected ?string $heading = 'Редагувати подію';

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return app(UpdateGroupEvent::class)->handle($record, GroupEventUpdateData::fromArray($data));
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
