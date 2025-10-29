<?php

namespace App\Actions\Groups;

use App\Enums\MemberRole;
use App\Enums\MemberStatus;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class JoinGroup
{
    use AsAction;

    public function handle(Group $group, User $user): bool
    {
        if ($group->members()->where('user_id', $user->id)->exists()) {
            return false;
        }

        $status = match ($group->join_policy->value) {
            'open' => MemberStatus::ACTIVE,
            'request' => MemberStatus::PENDING,
            'invite_only' => MemberStatus::PENDING,
            default => MemberStatus::PENDING,
        };

        $group->members()->attach($user->id, [
            'role' => MemberRole::MEMBER->value,
            'status' => $status->value,
            'joined_at' => Carbon::now(),
        ]);

        if ($status === MemberStatus::ACTIVE) {
            $group->increment('member_count');
        }

        return true;
    }
}
