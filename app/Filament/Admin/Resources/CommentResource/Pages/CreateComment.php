<?php

namespace App\Filament\Admin\Resources\CommentResource\Pages;

use App\Actions\Comments\CreateComment as CreateCommentAction;
use App\Data\Comment\CommentStoreData;
use App\Filament\Admin\Resources\CommentResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateComment extends CreateRecord
{
    protected static string $resource = CommentResource::class;

    protected ?string $heading = 'Створити коментар';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = CommentStoreData::fromArray($data);

        return app(CreateCommentAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Коментар створено';
    }
}
