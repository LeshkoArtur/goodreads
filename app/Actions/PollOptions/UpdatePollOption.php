<?php

namespace App\Actions\PollOptions;

use App\Data\PollOption\PollOptionUpdateData;
use App\Models\PollOption;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdatePollOption
{
    use AsAction;

    public function handle(PollOption $pollOption, PollOptionUpdateData $data): PollOption
    {
        $pollOption->text = $data->text;
        $pollOption->save();

        return $pollOption->fresh(['poll']);
    }
}
