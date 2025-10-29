<?php

namespace App\Actions\GroupInvitations;

use App\Models\GroupInvitation;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupInvitationInviter
{
    use AsAction;

    public function handle(GroupInvitation $groupInvitation): User
    {
        return $groupInvitation->inviter;
    }
}
