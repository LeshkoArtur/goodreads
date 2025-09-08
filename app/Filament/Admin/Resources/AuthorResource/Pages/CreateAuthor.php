<?php

namespace App\Filament\Admin\Resources\AuthorResource\Pages;

use App\DTOs\Author\AuthorStoreDTO;
use App\Filament\Admin\Resources\AuthorResource;
use App\Models\Author;
use App\Actions\Authors\CreateAuthor as CreateAuthorAction;
use Filament\Resources\Pages\CreateRecord;

class CreateAuthor extends CreateRecord
{
    protected static string $resource = AuthorResource::class;

    protected function handleRecordCreation(array $data): Author
    {
        $dto = AuthorStoreDTO::fromArray($data);

        return CreateAuthorAction::run($dto);
    }
}
