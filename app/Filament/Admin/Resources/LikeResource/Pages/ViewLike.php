<?php

namespace App\Filament\Admin\Resources\LikeResource\Pages;

use App\Filament\Admin\Resources\LikeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLike extends ViewRecord
{
    protected static string $resource = LikeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
