<?php

namespace App\Actions\PollOptions;

use App\Data\PollOption\PollOptionStoreData;
use App\Models\PollOption;
use Lorisleiva\Actions\Concerns\AsAction;

class CreatePollOption
{
    use AsAction;

    public function handle(PollOptionStoreData $data): PollOption
    {
        $pollOption = new PollOption;
        $pollOption->group_poll_id = $data->group_poll_id;
        $pollOption->text = $data->text;
        $pollOption->vote_count = 0;
        $pollOption->save();

        return $pollOption->fresh(['poll']);
    }
}
