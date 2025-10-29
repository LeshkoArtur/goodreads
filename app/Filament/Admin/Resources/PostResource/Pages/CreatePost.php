<?php

namespace App\Filament\Admin\Resources\PostResource\Pages;

use App\Actions\Posts\CreatePost as CreatePostAction;
use App\Data\Post\PostStoreData;
use App\Filament\Admin\Resources\PostResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected ?string $heading = 'Створити пост';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = PostStoreData::fromArray($data);

        return app(CreatePostAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Пост створено';
    }
}
