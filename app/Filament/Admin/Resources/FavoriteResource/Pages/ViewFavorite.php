<?php

namespace App\Filament\Admin\Resources\FavoriteResource\Pages;

use App\Filament\Admin\Resources\FavoriteResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFavorite extends ViewRecord
{
    protected static string $resource = FavoriteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
