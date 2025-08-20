<?php

namespace App\Models\Builders;

use App\Enums\InvitationStatus;
use Illuminate\Database\Eloquent\Builder;

class GroupInvitationQueryBuilder extends Builder
{
    /**
     * Запрошення для певної групи.
     */
    public function forGroup(string $groupId): static
    {
        return $this->where('group_id', $groupId);
    }

    /**
     * Запрошення від певного користувача.
     */
    public function byInviter(string $inviterId): static
    {
        return $this->where('inviter_id', $inviterId);
    }

    /**
     * Запрошення для певного запрошеного користувача.
     */
    public function forInvitee(string $inviteeId): static
    {
        return $this->where('invitee_id', $inviteeId);
    }

    /**
     * Запрошення з певним статусом.
     */
    public function withStatus(InvitationStatus $status): static
    {
        return $this->where('status', $status);
    }
}
