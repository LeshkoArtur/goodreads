<?php

namespace App\Actions\GroupEvents;

use App\Models\Group;
use App\Models\GroupEvent;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupEventGroup
{
    use AsAction;

    public function handle(GroupEvent $groupEvent): Group
    {
        return $groupEvent->group;
    }
}
