<?php

namespace App\Filament\Admin\Resources\BookResource\Pages;

use App\Actions\Books\UpdateBook;
use App\Data\Book\BookUpdateData;
use App\Filament\Admin\Resources\BookResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditBook extends EditRecord
{
    protected static string $resource = BookResource::class;

    protected ?string $heading = 'Редагувати книгу';

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
        $dto = BookUpdateData::fromArray($data);

        return app(UpdateBook::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Книгу оновлено';
    }
}
