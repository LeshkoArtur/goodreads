<?php

namespace App\Filament\Admin\Resources\GroupInvitationResource\Pages;

use App\Filament\Admin\Resources\GroupInvitationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGroupInvitation extends ViewRecord
{
    protected static string $resource = GroupInvitationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
