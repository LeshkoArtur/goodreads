<?php

namespace App\Filament\Admin\Resources\UserBookResource\Pages;

use App\Filament\Admin\Resources\UserBookResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserBooks extends ListRecords
{
    protected static string $resource = UserBookResource::class;

    protected ?string $heading = 'Книги користувачів';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Додати книгу'),
        ];
    }
}
