<?php

namespace App\Filament\Admin\Resources\GenreResource\Pages;

use App\Actions\Genres\UpdateGenre;
use App\Data\Genre\GenreUpdateData;
use App\Filament\Admin\Resources\GenreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditGenre extends EditRecord
{
    protected static string $resource = GenreResource::class;

    protected ?string $heading = 'Редагувати жанр';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('Переглянути'),
            Actions\DeleteAction::make()
                ->label('Видалити'),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = GenreUpdateData::fromArray($data);

        return app(UpdateGenre::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Жанр оновлено';
    }
}
