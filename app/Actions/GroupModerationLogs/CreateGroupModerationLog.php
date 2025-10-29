<?php

namespace App\Actions\GroupModerationLogs;

use App\Data\GroupModerationLog\GroupModerationLogStoreData;
use App\Models\GroupModerationLog;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateGroupModerationLog
{
    use AsAction;

    public function handle(GroupModerationLogStoreData $data, User $user): GroupModerationLog
    {
        $log = new GroupModerationLog;
        $log->group_id = $data->group_id;
        $log->moderator_id = $user->id;
        $log->action = $data->action;
        $log->targetable_type = $data->targetable_type;
        $log->targetable_id = $data->targetable_id;
        $log->description = $data->description;
        $log->save();

        return $log->fresh(['group', 'moderator', 'targetable']);
    }
}
