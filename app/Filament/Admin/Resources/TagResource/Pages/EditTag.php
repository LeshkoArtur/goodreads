<?php

namespace App\Filament\Admin\Resources\TagResource\Pages;

use App\Actions\Tags\UpdateTag;
use App\Data\Tag\TagUpdateData;
use App\Filament\Admin\Resources\TagResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditTag extends EditRecord
{
    protected static string $resource = TagResource::class;

    protected ?string $heading = 'Редагувати тег';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Видалити'),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = TagUpdateData::fromArray($data);

        return app(UpdateTag::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Тег оновлено';
    }
}
