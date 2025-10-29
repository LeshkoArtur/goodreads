<?php

namespace App\Filament\Admin\Resources\PollVoteResource\Pages;

use App\Actions\PollVotes\UpdatePollVote as UpdateAction;
use App\Data\PollVote\PollVoteUpdateData;
use App\Filament\Admin\Resources\PollVoteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditPollVote extends EditRecord
{
    protected static string $resource = PollVoteResource::class;

    protected ?string $heading = 'Редагувати голос';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = PollVoteUpdateData::fromArray($data);

        return app(UpdateAction::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Голос оновлено';
    }
}
