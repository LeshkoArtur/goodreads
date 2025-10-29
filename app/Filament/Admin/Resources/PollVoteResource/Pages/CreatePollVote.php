<?php

namespace App\Filament\Admin\Resources\PollVoteResource\Pages;

use App\Actions\PollVotes\CreatePollVote as CreateAction;
use App\Data\PollVote\PollVoteStoreData;
use App\Filament\Admin\Resources\PollVoteResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePollVote extends CreateRecord
{
    protected static string $resource = PollVoteResource::class;

    protected ?string $heading = 'Додати голос';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = PollVoteStoreData::fromArray($data);

        return app(CreateAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Голос додано';
    }
}
