<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class GroupModerationLogQueryBuilder extends Builder
{
    /**
     * Логи модерації для певної групи.
     */
    public function forGroup(string $groupId): static
    {
        return $this->where('group_id', $groupId);
    }

    /**
     * Логи модерації від певного модератора.
     */
    public function byModerator(string $moderatorId): static
    {
        return $this->where('moderator_id', $moderatorId);
    }

    /**
     * Логи модерації для певної дії.
     */
    public function withAction(string $action): static
    {
        return $this->where('action', $action);
    }

    /**
     * Логи модерації для певної сутності (targetable).
     */
    public function forTargetable(string $type, string $id): static
    {
        return $this->where('targetable_type', $type)->where('targetable_id', $id);
    }
}
