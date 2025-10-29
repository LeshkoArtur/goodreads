<?php

namespace App\Actions\Groups;

use App\Enums\InvitationStatus;
use App\Models\Group;
use App\Models\GroupInvitation;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class InviteUserToGroup
{
    use AsAction;

    public function handle(Group $group, User $inviter, User $invitee): bool
    {
        if ($group->members()->where('user_id', $invitee->id)->exists()) {
            return false;
        }

        if (GroupInvitation::where('group_id', $group->id)
            ->where('invitee_id', $invitee->id)
            ->where('status', InvitationStatus::PENDING->value)
            ->exists()) {
            return false;
        }

        GroupInvitation::create([
            'group_id' => $group->id,
            'inviter_id' => $inviter->id,
            'invitee_id' => $invitee->id,
            'status' => InvitationStatus::PENDING,
        ]);

        return true;
    }
}
