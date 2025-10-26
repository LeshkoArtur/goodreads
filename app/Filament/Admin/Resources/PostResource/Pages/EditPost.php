<?php

namespace App\Filament\Admin\Resources\PostResource\Pages;

use App\Actions\Posts\UpdatePost;
use App\DTOs\Post\PostUpdateDTO;
use App\Filament\Admin\Resources\PostResource;
use App\Models\Post;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Post|Model $record, array $data): Post
    {
        $dto = PostUpdateDTO::fromArray($data);

        return UpdatePost::run($record, $dto);
    }
}
