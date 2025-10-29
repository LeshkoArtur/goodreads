<?php

namespace App\Actions\Groups;

use App\Data\Group\GroupRelationIndexData;
use App\Models\Group;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupEvents
{
    use AsAction;

    public function handle(Group $group, GroupRelationIndexData $data): LengthAwarePaginator
    {
        $query = $group->events()->with(['creator']);

        if ($data->sort && in_array($data->sort, ['created_at', 'event_date'])) {
            $query->orderBy($data->sort, $data->direction ?? 'asc');
        }

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
