<?php

namespace App\Actions\GroupModerationLogs;

use App\Data\GroupModerationLog\GroupModerationLogUpdateData;
use App\Models\GroupModerationLog;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateGroupModerationLog
{
    use AsAction;

    public function handle(GroupModerationLog $log, GroupModerationLogUpdateData $data): GroupModerationLog
    {
        $log->update(array_filter([
            'group_id' => $data->group_id,
            'moderator_id' => $data->moderator_id,
            'action' => $data->action,
            'targetable_id' => $data->targetable_id,
            'targetable_type' => $data->targetable_type,
            'description' => $data->description,
        ], fn ($value) => $value !== null));

        return $log->fresh(['group', 'moderator', 'targetable']);
    }
}
