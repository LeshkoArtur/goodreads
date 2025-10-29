<?php

namespace App\Filament\Admin\Resources\GroupPostResource\Pages;

use App\Actions\GroupPosts\UpdateGroupPost;
use App\Data\GroupPost\GroupPostUpdateData;
use App\Filament\Admin\Resources\GroupPostResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditGroupPost extends EditRecord
{
    protected static string $resource = GroupPostResource::class;

    protected ?string $heading = 'Редагувати пост групи';

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return app(UpdateGroupPost::class)->handle($record, GroupPostUpdateData::fromArray($data));
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Пост оновлено';
    }
}
