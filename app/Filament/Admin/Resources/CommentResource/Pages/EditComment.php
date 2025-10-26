<?php

namespace App\Filament\Admin\Resources\CommentResource\Pages;

use App\Actions\Comments\UpdateComment;
use App\DTOs\Comment\CommentUpdateDTO;
use App\Filament\Admin\Resources\CommentResource;
use App\Models\Comment;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditComment extends EditRecord
{
    protected static string $resource = CommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Comment|Model $record, array $data): Comment
    {
        $dto = CommentUpdateDTO::fromArray($data);

        return UpdateComment::run($record, $dto);
    }
}
