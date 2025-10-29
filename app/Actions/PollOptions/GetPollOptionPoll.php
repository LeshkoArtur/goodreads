<?php

namespace App\Actions\PollOptions;

use App\Models\GroupPoll;
use App\Models\PollOption;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPollOptionPoll
{
    use AsAction;

    public function handle(PollOption $pollOption): GroupPoll
    {
        return $pollOption->poll;
    }
}
