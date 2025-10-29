<?php

namespace App\Actions\Groups;

use App\Enums\MemberRole;
use App\Models\Group;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupStats
{
    use AsAction;

    public function handle(Group $group): array
    {
        return [
            'total_members' => $group->members()->count(),
            'total_posts' => $group->posts()->count(),
            'total_events' => $group->events()->count(),
            'total_polls' => $group->polls()->count(),
            'active_polls' => $group->polls()->where('is_active', true)->count(),
            'upcoming_events' => $group->events()->where('event_date', '>=', now())->count(),
            'admins_count' => $group->members()->wherePivot('role', MemberRole::ADMIN->value)->count(),
            'moderators_count' => $group->members()->wherePivot('role', MemberRole::MODERATOR->value)->count(),
        ];
    }
}
