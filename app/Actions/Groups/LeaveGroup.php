<?php

namespace App\Actions\Groups;

use App\Enums\MemberStatus;
use App\Models\Group;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class LeaveGroup
{
    use AsAction;

    public function handle(Group $group, User $user): bool
    {
        $member = $group->members()->where('user_id', $user->id)->first();

        if (! $member) {
            return false;
        }

        if ($member->pivot->status === MemberStatus::ACTIVE->value) {
            $group->decrement('member_count');
        }

        $group->members()->detach($user->id);

        return true;
    }
}
