<?php

namespace App\Actions\GroupModerationLogs;

use App\Data\GroupModerationLog\GroupModerationLogFilterData;
use App\Models\Group;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupModerationLogsByGroup
{
    use AsAction;

    public function handle(Group $group, GroupModerationLogFilterData $data): LengthAwarePaginator
    {
        return $group->moderationLogs()
            ->with(['moderator', 'targetable'])
            ->latest()
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
