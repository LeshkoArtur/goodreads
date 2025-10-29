<?php

namespace App\Filament\Admin\Resources\GroupEventResource\Pages;

use App\Actions\GroupEvents\CreateGroupEvent as CreateGroupEventAction;
use App\Data\GroupEvent\GroupEventStoreData;
use App\Filament\Admin\Resources\GroupEventResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateGroupEvent extends CreateRecord
{
    protected static string $resource = GroupEventResource::class;

    protected ?string $heading = 'Створити подію';

    protected function handleRecordCreation(array $data): Model
    {
        return app(CreateGroupEventAction::class)->handle(GroupEventStoreData::fromArray($data));
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
