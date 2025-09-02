<?php

namespace App\Actions\GroupModerationLogs;

use App\DTOs\GroupModerationLog\GroupModerationLogUpdateDTO;
use App\Models\GroupModerationLog;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateGroupModerationLog
{
    use AsAction;

    /**
     * Оновити існуючий лог модерації групи.
     *
     * @param GroupModerationLog $groupModerationLog
     * @param GroupModerationLogUpdateDTO $dto
     * @return GroupModerationLog
     */
    public function handle(GroupModerationLog $groupModerationLog, GroupModerationLogUpdateDTO $dto): GroupModerationLog
    {
        $attributes = [
            'action' => $dto->action,
            'description' => $dto->description,
        ];

        $groupModerationLog->fill(array_filter($attributes, fn($value) => $value !== null));

        $groupModerationLog->save();

        return $groupModerationLog->load(['group', 'moderator', 'targetable']);
    }
}
