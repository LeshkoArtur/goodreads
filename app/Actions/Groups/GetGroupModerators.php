<?php

namespace App\Actions\Groups;

use App\Data\Group\GroupRelationIndexData;
use App\Enums\MemberRole;
use App\Models\Group;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupModerators
{
    use AsAction;

    public function handle(Group $group, GroupRelationIndexData $data): LengthAwarePaginator
    {
        $query = $group->members()
            ->withPivot('role', 'status', 'joined_at')
            ->wherePivot('role', MemberRole::MODERATOR->value);

        if ($data->sort && in_array($data->sort, ['joined_at'])) {
            $query->orderByPivot($data->sort, $data->direction ?? 'desc');
        }

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
