<?php

namespace App\Filament\Admin\Resources\AuthorAnswerResource\Pages;

use App\Actions\AuthorAnswers\CreateAuthorAnswer as CreateAction;
use App\Data\AuthorAnswer\AuthorAnswerStoreData;
use App\Filament\Admin\Resources\AuthorAnswerResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateAuthorAnswer extends CreateRecord
{
    protected static string $resource = AuthorAnswerResource::class;

    protected ?string $heading = 'Створити відповідь автора';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = AuthorAnswerStoreData::fromArray($data);

        return app(CreateAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Відповідь автора створено';
    }
}
