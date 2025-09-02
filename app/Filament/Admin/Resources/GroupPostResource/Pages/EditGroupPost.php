<?php

namespace App\Filament\Admin\Resources\GroupPostResource\Pages;

use App\Filament\Admin\Resources\GroupPostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGroupPost extends EditRecord
{
    protected static string $resource = GroupPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
