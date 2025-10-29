<?php

namespace App\Filament\Admin\Resources\AuthorResource\Pages;

use App\Actions\Authors\UpdateAuthor;
use App\Data\Author\AuthorUpdateData;
use App\Filament\Admin\Resources\AuthorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditAuthor extends EditRecord
{
    protected static string $resource = AuthorResource::class;

    protected ?string $heading = 'Редагувати автора';

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
        $dto = AuthorUpdateData::fromArray($data);

        return app(UpdateAuthor::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Автора оновлено';
    }
}
