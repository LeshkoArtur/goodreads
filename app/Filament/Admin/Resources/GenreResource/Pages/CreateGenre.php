<?php

namespace App\Filament\Admin\Resources\GenreResource\Pages;

use App\Actions\Genres\CreateGenre as CreateGenreAction;
use App\Data\Genre\GenreStoreData;
use App\Filament\Admin\Resources\GenreResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateGenre extends CreateRecord
{
    protected static string $resource = GenreResource::class;

    protected ?string $heading = 'Створити жанр';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = GenreStoreData::fromArray($data);

        return app(CreateGenreAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Жанр створено';
    }
}
