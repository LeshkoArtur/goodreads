<?php

namespace App\Filament\Admin\Resources\GroupEventResource\Pages;

use App\Actions\GroupEvents\UpdateGroupEvent;
use App\DTOs\GroupEvent\GroupEventUpdateDTO;
use App\Filament\Admin\Resources\GroupEventResource;
use App\Models\GroupEvent;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditGroupEvent extends EditRecord
{
    protected static string $resource = GroupEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(GroupEvent|Model $record, array $data): GroupEvent
    {
        $dto = GroupEventUpdateDTO::fromArray($data);

        return UpdateGroupEvent::run($record, $dto);
    }
}
