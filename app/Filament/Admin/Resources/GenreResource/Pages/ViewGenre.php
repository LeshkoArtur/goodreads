<?php

namespace App\Filament\Admin\Resources\GenreResource\Pages;

use App\Filament\Admin\Resources\GenreResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGenre extends ViewRecord
{
    protected static string $resource = GenreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
