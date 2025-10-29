<?php

namespace App\Filament\Admin\Resources\TagResource\Pages;

use App\Filament\Admin\Resources\TagResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTags extends ListRecords
{
    protected static string $resource = TagResource::class;

    protected ?string $heading = 'Теги';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Створити тег'),
        ];
    }
}
