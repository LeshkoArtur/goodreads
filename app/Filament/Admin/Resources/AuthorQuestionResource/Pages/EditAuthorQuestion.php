<?php

namespace App\Filament\Admin\Resources\AuthorQuestionResource\Pages;

use App\Actions\AuthorQuestions\UpdateAuthorQuestion as UpdateAction;
use App\Data\AuthorQuestion\AuthorQuestionUpdateData;
use App\Filament\Admin\Resources\AuthorQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditAuthorQuestion extends EditRecord
{
    protected static string $resource = AuthorQuestionResource::class;

    protected ?string $heading = 'Редагувати питання до автора';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = AuthorQuestionUpdateData::fromArray($data);

        return app(UpdateAction::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Питання до автора оновлено';
    }
}
