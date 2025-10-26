<?php

namespace App\Filament\Admin\Resources\AwardResource\Pages;

use App\Actions\Awards\UpdateAward;
use App\DTOs\Award\AwardUpdateDTO;
use App\Filament\Admin\Resources\AwardResource;
use App\Models\Award;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditAward extends EditRecord
{
    protected static string $resource = AwardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Award|Model $record, array $data): Award
    {
        $dto = AwardUpdateDTO::fromArray($data);

        return UpdateAward::run($record, $dto);
    }
}
