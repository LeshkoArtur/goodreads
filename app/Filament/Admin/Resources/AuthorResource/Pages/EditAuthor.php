<?php

namespace App\Filament\Admin\Resources\AuthorResource\Pages;

use App\Actions\Authors\UpdateAuthor;
use App\DTOs\Author\AuthorUpdateDTO;
use App\Filament\Admin\Resources\AuthorResource;
use App\Models\Author;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditAuthor extends EditRecord
{
    protected static string $resource = AuthorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Author|Model $record, array $data): Author
    {
        $dto = AuthorUpdateDTO::fromArray($data);

        return UpdateAuthor::run($record, $dto);
    }
}
