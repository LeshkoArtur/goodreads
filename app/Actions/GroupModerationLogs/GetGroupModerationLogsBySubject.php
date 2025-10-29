<?php

namespace App\Actions\GroupModerationLogs;

use App\Data\GroupModerationLog\GroupModerationLogFilterData;
use App\Models\GroupModerationLog;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupModerationLogsBySubject
{
    use AsAction;

    public function handle(User $user, GroupModerationLogFilterData $data): LengthAwarePaginator
    {
        return GroupModerationLog::where(function ($query) use ($user) {
            $query->where('targetable_type', 'App\Models\GroupPost')
                ->whereHas('targetable', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->orWhere(function ($query) use ($user) {
                    $query->where('targetable_type', 'App\Models\Comment')
                        ->whereHas('targetable', function ($q) use ($user) {
                            $q->where('user_id', $user->id);
                        });
                });
        })
            ->with(['group', 'moderator', 'targetable'])
            ->latest()
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
