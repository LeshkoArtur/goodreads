<?php

namespace App\Actions\GroupInvitations;

use App\Models\Group;
use App\Models\GroupInvitation;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupInvitationGroup
{
    use AsAction;

    public function handle(GroupInvitation $groupInvitation): Group
    {
        return $groupInvitation->group;
    }
}
