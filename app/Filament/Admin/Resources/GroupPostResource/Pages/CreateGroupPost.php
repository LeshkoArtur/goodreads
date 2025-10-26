<?php

namespace App\Filament\Admin\Resources\GroupPostResource\Pages;

use App\DTOs\GroupPost\GroupPostStoreDTO;
use App\Filament\Admin\Resources\GroupPostResource;
use App\Models\GroupPost;
use App\Actions\GroupPosts\CreateGroupPost as CreateGroupPostAction;
use Filament\Resources\Pages\CreateRecord;

class CreateGroupPost extends CreateRecord
{
    protected static string $resource = GroupPostResource::class;

    protected function handleRecordCreation(array $data): GroupPost
    {
        $dto = GroupPostStoreDTO::fromArray($data);

        return CreateGroupPostAction::run($dto);
    }
}
