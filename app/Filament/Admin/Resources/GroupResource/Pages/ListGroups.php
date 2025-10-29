<?php

namespace App\Filament\Admin\Resources\GroupResource\Pages;

use App\Filament\Admin\Resources\GroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGroups extends ListRecords
{
    protected static string $resource = GroupResource::class;

    protected ?string $heading = 'Групи';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Створити групу'),
        ];
    }
}
