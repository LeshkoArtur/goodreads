<?php

namespace App\Actions\GroupInvitations;

use App\Enums\InvitationStatus;
use App\Models\GroupInvitation;
use Lorisleiva\Actions\Concerns\AsAction;

class RejectGroupInvitation
{
    use AsAction;

    public function handle(GroupInvitation $groupInvitation): GroupInvitation
    {
        $groupInvitation->status = InvitationStatus::REJECTED;
        $groupInvitation->save();

        return $groupInvitation->fresh(['group', 'inviter', 'invitee']);
    }
}
