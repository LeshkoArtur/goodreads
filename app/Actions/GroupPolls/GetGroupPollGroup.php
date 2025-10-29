<?php

namespace App\Actions\GroupPolls;

use App\Models\Group;
use App\Models\GroupPoll;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupPollGroup
{
    use AsAction;

    public function handle(GroupPoll $groupPoll): Group
    {
        return $groupPoll->group;
    }
}
