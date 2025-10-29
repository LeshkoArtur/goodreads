<?php

namespace App\Filament\Admin\Resources\GroupPostResource\Pages;

use App\Actions\GroupPosts\CreateGroupPost as CreateGroupPostAction;
use App\Data\GroupPost\GroupPostStoreData;
use App\Filament\Admin\Resources\GroupPostResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateGroupPost extends CreateRecord
{
    protected static string $resource = GroupPostResource::class;

    protected ?string $heading = 'Створити пост групи';

    protected function handleRecordCreation(array $data): Model
    {
        return app(CreateGroupPostAction::class)->handle(GroupPostStoreData::fromArray($data));
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Пост створено';
    }
}
