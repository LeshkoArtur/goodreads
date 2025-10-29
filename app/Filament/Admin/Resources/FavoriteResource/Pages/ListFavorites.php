<?php

namespace App\Filament\Admin\Resources\FavoriteResource\Pages;

use App\Filament\Admin\Resources\FavoriteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFavorites extends ListRecords
{
    protected static string $resource = FavoriteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Додати в обране'),
        ];
    }
}
