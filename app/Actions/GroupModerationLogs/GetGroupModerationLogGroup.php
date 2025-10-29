<?php

namespace App\Actions\GroupModerationLogs;

use App\Models\Group;
use App\Models\GroupModerationLog;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupModerationLogGroup
{
    use AsAction;

    public function handle(GroupModerationLog $groupModerationLog): Group
    {
        return $groupModerationLog->group;
    }
}
