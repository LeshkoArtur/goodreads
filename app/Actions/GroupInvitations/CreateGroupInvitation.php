<?php

namespace App\Actions\GroupInvitations;

use App\Data\GroupInvitation\GroupInvitationStoreData;
use App\Enums\InvitationStatus;
use App\Models\GroupInvitation;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateGroupInvitation
{
    use AsAction;

    public function handle(GroupInvitationStoreData $data, User $user): GroupInvitation
    {
        $groupInvitation = new GroupInvitation;
        $groupInvitation->group_id = $data->group_id;
        $groupInvitation->inviter_id = $user->id;
        $groupInvitation->invitee_id = $data->invitee_id;
        $groupInvitation->status = InvitationStatus::PENDING;
        $groupInvitation->save();

        return $groupInvitation->fresh(['group', 'inviter', 'invitee']);
    }
}
