<?php

namespace App\Filament\Admin\Resources\GroupResource\Pages;

use App\Actions\Groups\UpdateGroup;
use App\DTOs\Group\GroupUpdateDTO;
use App\Filament\Admin\Resources\GroupResource;
use App\Models\Group;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditGroup extends EditRecord
{
    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Group|Model $record, array $data): Group
    {
        $dto = GroupUpdateDTO::fromArray($data);

        return UpdateGroup::run($record, $dto);
    }
}
