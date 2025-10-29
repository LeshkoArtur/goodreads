<?php

namespace App\Filament\Admin\Resources\ShelfResource\Pages;

use App\Filament\Admin\Resources\ShelfResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewShelf extends ViewRecord
{
    protected static string $resource = ShelfResource::class;

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
