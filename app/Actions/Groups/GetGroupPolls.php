<?php

namespace App\Actions\Groups;

use App\Data\Group\GroupRelationIndexData;
use App\Models\Group;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupPolls
{
    use AsAction;

    public function handle(Group $group, GroupRelationIndexData $data): LengthAwarePaginator
    {
        $query = $group->polls()->with(['creator']);

        if ($data->sort && in_array($data->sort, ['created_at'])) {
            $query->orderBy($data->sort, $data->direction ?? 'desc');
        }

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
