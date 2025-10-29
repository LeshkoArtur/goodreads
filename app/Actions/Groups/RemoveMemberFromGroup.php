<?php

namespace App\Actions\Groups;

use App\Enums\MemberStatus;
use App\Models\Group;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class RemoveMemberFromGroup
{
    use AsAction;

    public function handle(Group $group, User $member): bool
    {
        $memberRecord = $group->members()->where('user_id', $member->id)->first();

        if (! $memberRecord) {
            return false;
        }

        if ($memberRecord->pivot->status === MemberStatus::ACTIVE->value) {
            $group->decrement('member_count');
        }

        $group->members()->detach($member->id);

        return true;
    }
}
