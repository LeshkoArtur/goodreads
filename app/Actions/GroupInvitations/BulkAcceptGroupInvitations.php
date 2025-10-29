<?php

namespace App\Actions\GroupInvitations;

use App\Data\GroupInvitation\GroupInvitationBulkData;
use App\Enums\InvitationStatus;
use App\Models\GroupInvitation;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class BulkAcceptGroupInvitations
{
    use AsAction;

    public function handle(GroupInvitationBulkData $data, User $user): int
    {
        return GroupInvitation::whereIn('id', $data->invitation_ids)
            ->where('invitee_id', $user->id)
            ->where('status', InvitationStatus::PENDING)
            ->update(['status' => InvitationStatus::ACCEPTED]);
    }
}
