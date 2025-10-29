<?php

namespace App\Filament\Admin\Resources\LikeResource\Pages;

use App\Filament\Admin\Resources\LikeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLikes extends ListRecords
{
    protected static string $resource = LikeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Поставити лайк'),
        ];
    }
}
