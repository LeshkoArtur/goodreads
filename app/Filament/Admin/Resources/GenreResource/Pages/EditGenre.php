<?php

namespace App\Filament\Admin\Resources\GenreResource\Pages;

use App\Actions\Genres\UpdateGenre;
use App\DTOs\Genre\GenreUpdateDTO;
use App\Filament\Admin\Resources\GenreResource;
use App\Models\Genre;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditGenre extends EditRecord
{
    protected static string $resource = GenreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Genre|Model $record, array $data): Genre
    {
        $dto = GenreUpdateDTO::fromArray($data);

        return UpdateGenre::run($record, $dto);
    }
}
