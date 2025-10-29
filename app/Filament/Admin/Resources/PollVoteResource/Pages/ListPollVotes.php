<?php

namespace App\Filament\Admin\Resources\PollVoteResource\Pages;

use App\Filament\Admin\Resources\PollVoteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPollVotes extends ListRecords
{
    protected static string $resource = PollVoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Додати голос'),
        ];
    }
}
