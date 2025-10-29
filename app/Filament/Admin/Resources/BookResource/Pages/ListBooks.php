<?php

namespace App\Filament\Admin\Resources\BookResource\Pages;

use App\Filament\Admin\Resources\BookResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBooks extends ListRecords
{
    protected static string $resource = BookResource::class;

    protected ?string $heading = 'Книги';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Створити книгу'),
        ];
    }
}
