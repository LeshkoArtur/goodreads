<?php

namespace App\Actions\Groups;

use App\Enums\MemberRole;
use App\Models\Group;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateMemberRole
{
    use AsAction;

    public function handle(Group $group, User $member, string $role): bool
    {
        if (! $group->members()->where('user_id', $member->id)->exists()) {
            return false;
        }

        $validRoles = array_map(fn ($case) => $case->value, MemberRole::cases());
        if (! in_array($role, $validRoles)) {
            return false;
        }

        $group->members()->updateExistingPivot($member->id, ['role' => $role]);

        return true;
    }
}
