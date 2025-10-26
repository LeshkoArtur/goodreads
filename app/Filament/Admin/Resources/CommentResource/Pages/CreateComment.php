<?php

namespace App\Filament\Admin\Resources\CommentResource\Pages;

use App\DTOs\Comment\CommentStoreDTO;
use App\Filament\Admin\Resources\CommentResource;
use App\Models\Comment;
use App\Actions\Comments\CreateComment as CreateCommentAction;
use Filament\Resources\Pages\CreateRecord;

class CreateComment extends CreateRecord
{
    protected static string $resource = CommentResource::class;

    protected function handleRecordCreation(array $data): Comment
    {
        $dto = CommentStoreDTO::fromArray($data);

        return CreateCommentAction::run($dto);
    }
}
