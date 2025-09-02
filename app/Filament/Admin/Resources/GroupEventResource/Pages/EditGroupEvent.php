<?php

namespace App\Filament\Admin\Resources\GroupEventResource\Pages;

use App\Filament\Admin\Resources\GroupEventResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGroupEvent extends EditRecord
{
    protected static string $resource = GroupEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
