<?php

namespace App\Actions\Groups;

use App\Models\Group;
use Illuminate\Support\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupActivity
{
    use AsAction;

    public function handle(Group $group): array
    {
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        return [
            'posts_last_30_days' => $group->posts()->where('created_at', '>=', $thirtyDaysAgo)->count(),
            'new_members_last_30_days' => $group->members()->wherePivot('joined_at', '>=', $thirtyDaysAgo)->count(),
            'events_last_30_days' => $group->events()->where('created_at', '>=', $thirtyDaysAgo)->count(),
            'most_active_member' => $group->posts()
                ->select('user_id')
                ->selectRaw('COUNT(*) as posts_count')
                ->where('created_at', '>=', $thirtyDaysAgo)
                ->groupBy('user_id')
                ->orderByDesc('posts_count')
                ->with('user')
                ->first(),
        ];
    }
}
