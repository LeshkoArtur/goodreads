<?php

namespace App\Filament\Admin\Resources\ShelfResource\Pages;

use App\Actions\Shelves\UpdateShelf;
use App\Data\Shelf\ShelfUpdateData;
use App\Filament\Admin\Resources\ShelfResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditShelf extends EditRecord
{
    protected static string $resource = ShelfResource::class;

    protected ?string $heading = 'Редагувати полицю';

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
        $dto = ShelfUpdateData::fromArray($data);

        return app(UpdateShelf::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Полицю оновлено';
    }
}
