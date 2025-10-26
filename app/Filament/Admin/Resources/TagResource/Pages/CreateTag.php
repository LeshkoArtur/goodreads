<?php

namespace App\Filament\Admin\Resources\TagResource\Pages;

use App\DTOs\Tag\TagStoreDTO;
use App\Filament\Admin\Resources\TagResource;
use App\Models\Tag;
use App\Actions\Tags\CreateTag as CreateTagAction;
use Filament\Resources\Pages\CreateRecord;

class CreateTag extends CreateRecord
{
    protected static string $resource = TagResource::class;

    protected function handleRecordCreation(array $data): Tag
    {
        $dto = TagStoreDTO::fromArray($data);

        return CreateTagAction::run($dto);
    }
}
