<?php

namespace App\Actions\GroupModerationLogs;

use App\DTOs\GroupModerationLog\GroupModerationLogStoreDTO;
use App\Models\GroupModerationLog;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateGroupModerationLog
{
    use AsAction;

    /**
     * Створити новий лог модерації групи.
     *
     * @param GroupModerationLogStoreDTO $dto
     * @return GroupModerationLog
     */
    public function handle(GroupModerationLogStoreDTO $dto): GroupModerationLog
    {
        $groupModerationLog = new GroupModerationLog();
        $groupModerationLog->group_id = $dto->groupId;
        $groupModerationLog->moderator_id = $dto->moderatorId;
        $groupModerationLog->action = $dto->action;
        $groupModerationLog->targetable_id = $dto->targetableId;
        $groupModerationLog->targetable_type = $dto->targetableType;
        $groupModerationLog->description = $dto->description;

        $groupModerationLog->save();

        return $groupModerationLog->load(['group', 'moderator', 'targetable']);
    }
}
