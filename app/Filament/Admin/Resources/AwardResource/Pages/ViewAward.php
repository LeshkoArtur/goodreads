<?php

namespace App\Filament\Admin\Resources\AwardResource\Pages;

use App\Filament\Admin\Resources\AwardResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAward extends ViewRecord
{
    protected static string $resource = AwardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Редагувати'),
            Actions\DeleteAction::make()
                ->label('Видалити'),
        ];
    }
}
