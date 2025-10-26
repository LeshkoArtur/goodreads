<?php

namespace App\Filament\Admin\Resources\GenreResource\Pages;

use App\DTOs\Genre\GenreStoreDTO;
use App\Filament\Admin\Resources\GenreResource;
use App\Models\Genre;
use App\Actions\Genres\CreateGenre as CreateGenreAction;
use Filament\Resources\Pages\CreateRecord;

class CreateGenre extends CreateRecord
{
    protected static string $resource = GenreResource::class;

    protected function handleRecordCreation(array $data): Genre
    {
        $dto = GenreStoreDTO::fromArray($data);

        return CreateGenreAction::run($dto);
    }
}
