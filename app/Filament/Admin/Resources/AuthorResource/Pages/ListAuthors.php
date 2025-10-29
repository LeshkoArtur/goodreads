<?php

namespace App\Filament\Admin\Resources\AuthorResource\Pages;

use App\Filament\Admin\Resources\AuthorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAuthors extends ListRecords
{
    protected static string $resource = AuthorResource::class;

    protected ?string $heading = 'Автори';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Створити автора'),
        ];
    }
}
