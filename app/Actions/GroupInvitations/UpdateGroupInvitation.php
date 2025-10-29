<?php

namespace App\Actions\GroupInvitations;

use App\Data\GroupInvitation\GroupInvitationUpdateData;
use App\Models\GroupInvitation;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateGroupInvitation
{
    use AsAction;

    public function handle(GroupInvitation $groupInvitation, GroupInvitationUpdateData $data): GroupInvitation
    {
        $groupInvitation->update(array_filter([
            'group_id' => $data->group_id,
            'inviter_id' => $data->inviter_id,
            'invitee_id' => $data->invitee_id,
            'status' => $data->status,
        ], fn ($value) => $value !== null));

        return $groupInvitation->fresh(['group', 'inviter', 'invitee']);
    }
}
