<?php

namespace App\Filament\Admin\Resources\UserBookResource\Pages;

use App\Actions\UserBooks\UpdateUserBook;
use App\Data\UserBook\UserBookUpdateData;
use App\Filament\Admin\Resources\UserBookResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditUserBook extends EditRecord
{
    protected static string $resource = UserBookResource::class;

    protected ?string $heading = 'Редагувати книгу користувача';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Видалити'),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = UserBookUpdateData::fromArray($data);

        return app(UpdateUserBook::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Оновлено';
    }
}
