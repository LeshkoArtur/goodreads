<?php

namespace App\Filament\Admin\Resources\GroupPostResource\Pages;

use App\Actions\GroupPosts\UpdateGroupPost;
use App\DTOs\GroupPost\GroupPostUpdateDTO;
use App\Filament\Admin\Resources\GroupPostResource;
use App\Models\GroupPost;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditGroupPost extends EditRecord
{
    protected static string $resource = GroupPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(GroupPost|Model $record, array $data): GroupPost
    {
        $dto = GroupPostUpdateDTO::fromArray($data);

        return UpdateGroupPost::run($record, $dto);
    }
}
