<?php

namespace App\Actions\GroupModerationLogs;

use App\Data\GroupModerationLog\GroupModerationLogFilterData;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupModerationLogsByModerator
{
    use AsAction;

    public function handle(User $user, GroupModerationLogFilterData $data): LengthAwarePaginator
    {
        return $user->moderationActions()
            ->with(['group', 'targetable'])
            ->latest()
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
