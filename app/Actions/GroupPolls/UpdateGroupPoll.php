<?php

namespace App\Actions\GroupPolls;

use App\Data\GroupPoll\GroupPollUpdateData;
use App\Models\GroupPoll;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateGroupPoll
{
    use AsAction;

    public function handle(GroupPoll $groupPoll, GroupPollUpdateData $data): GroupPoll
    {
        $groupPoll->question = $data->question;

        if ($data->is_active !== null) {
            $groupPoll->is_active = $data->is_active;
        }

        $groupPoll->save();

        return $groupPoll->fresh(['group', 'creator', 'options']);
    }
}
