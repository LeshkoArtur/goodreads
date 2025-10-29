<?php

namespace App\Filament\Admin\Resources\AuthorQuestionResource\Pages;

use App\Actions\AuthorQuestions\CreateAuthorQuestion as CreateAction;
use App\Data\AuthorQuestion\AuthorQuestionStoreData;
use App\Filament\Admin\Resources\AuthorQuestionResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateAuthorQuestion extends CreateRecord
{
    protected static string $resource = AuthorQuestionResource::class;

    protected ?string $heading = 'Створити питання до автора';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = AuthorQuestionStoreData::fromArray($data);

        return app(CreateAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Питання до автора створено';
    }
}
