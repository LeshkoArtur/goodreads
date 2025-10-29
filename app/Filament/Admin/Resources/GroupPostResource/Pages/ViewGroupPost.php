<?php

namespace App\Filament\Admin\Resources\GroupPostResource\Pages;

use App\Filament\Admin\Resources\GroupPostResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGroupPost extends ViewRecord
{
    protected static string $resource = GroupPostResource::class;

    protected ?string $heading = 'Перегляд поста групи';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->label('Редагувати'),
            Actions\DeleteAction::make()->label('Видалити'),
        ];
    }
}
