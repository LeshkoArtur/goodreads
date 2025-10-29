<?php

namespace App\Filament\Admin\Resources\GroupInvitationResource\Pages;

use App\Filament\Admin\Resources\GroupInvitationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGroupInvitations extends ListRecords
{
    protected static string $resource = GroupInvitationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Створити запрошення'),
        ];
    }
}
