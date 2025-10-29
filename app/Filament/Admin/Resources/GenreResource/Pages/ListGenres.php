<?php

namespace App\Filament\Admin\Resources\GenreResource\Pages;

use App\Filament\Admin\Resources\GenreResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGenres extends ListRecords
{
    protected static string $resource = GenreResource::class;

    protected ?string $heading = 'Жанри';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Створити жанр'),
        ];
    }
}
