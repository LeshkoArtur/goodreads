<?php

namespace App\Filament\Admin\Resources\TagResource\Pages;

use App\Actions\Tags\UpdateTag;
use App\DTOs\Tag\TagUpdateDTO;
use App\Filament\Admin\Resources\TagResource;
use App\Models\Tag;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditTag extends EditRecord
{
    protected static string $resource = TagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Tag|Model $record, array $data): Tag
    {
        $dto = TagUpdateDTO::fromArray($data);

        return UpdateTag::run($record, $dto);
    }
}
