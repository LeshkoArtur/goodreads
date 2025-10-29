<?php

namespace App\Actions\GroupModerationLogs;

use App\Models\GroupModerationLog;
use Illuminate\Database\Eloquent\Model;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupModerationLogTargetable
{
    use AsAction;

    public function handle(GroupModerationLog $groupModerationLog): ?Model
    {
        return $groupModerationLog->targetable;
    }
}
