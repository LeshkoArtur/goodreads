<?php

namespace App\Filament\Admin\Resources\CommentResource\Pages;

use App\Actions\Comments\UpdateComment;
use App\Data\Comment\CommentUpdateData;
use App\Filament\Admin\Resources\CommentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditComment extends EditRecord
{
    protected static string $resource = CommentResource::class;

    protected ?string $heading = 'Редагувати коментар';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Видалити'),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = CommentUpdateData::fromArray($data);

        return app(UpdateComment::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Коментар оновлено';
    }
}
