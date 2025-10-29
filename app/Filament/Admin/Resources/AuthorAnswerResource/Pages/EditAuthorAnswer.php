<?php

namespace App\Filament\Admin\Resources\AuthorAnswerResource\Pages;

use App\Actions\AuthorAnswers\UpdateAuthorAnswer as UpdateAction;
use App\Data\AuthorAnswer\AuthorAnswerUpdateData;
use App\Filament\Admin\Resources\AuthorAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditAuthorAnswer extends EditRecord
{
    protected static string $resource = AuthorAnswerResource::class;

    protected ?string $heading = 'Редагувати відповідь автора';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = AuthorAnswerUpdateData::fromArray($data);

        return app(UpdateAction::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Відповідь автора оновлено';
    }
}
