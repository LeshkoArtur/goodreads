<?php

namespace App\Filament\Admin\Resources\PostResource\Pages;

use App\DTOs\Post\PostStoreDTO;
use App\Filament\Admin\Resources\PostResource;
use App\Models\Post;
use App\Actions\Posts\CreatePost as CreatePostAction;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function handleRecordCreation(array $data): Post
    {
        $dto = PostStoreDTO::fromArray($data);

        return CreatePostAction::run($dto);
    }
}
