<?php

namespace App\Actions\GroupModerationLogs;

use App\Models\GroupModerationLog;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupModerationLogModerator
{
    use AsAction;

    public function handle(GroupModerationLog $groupModerationLog): User
    {
        return $groupModerationLog->moderator;
    }
}
