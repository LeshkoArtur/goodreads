<?php

namespace App\Actions\Groups;

use App\Enums\MemberStatus;
use App\Models\Group;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class UnbanMember
{
    use AsAction;

    public function handle(Group $group, User $member): bool
    {
        $memberRecord = $group->members()->where('user_id', $member->id)->first();

        if (! $memberRecord || $memberRecord->pivot->status !== MemberStatus::BANNED->value) {
            return false;
        }

        $group->members()->updateExistingPivot($member->id, ['status' => MemberStatus::ACTIVE->value]);
        $group->increment('member_count');

        return true;
    }
}
