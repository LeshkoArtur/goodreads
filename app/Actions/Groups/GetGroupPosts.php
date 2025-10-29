<?php

namespace App\Actions\Groups;

use App\Data\Group\GroupRelationIndexData;
use App\Models\Group;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupPosts
{
    use AsAction;

    public function handle(Group $group, GroupRelationIndexData $data): LengthAwarePaginator
    {
        $query = $group->posts()->with(['user']);

        if ($data->sort && in_array($data->sort, ['created_at', 'is_pinned'])) {
            $query->orderBy($data->sort, $data->direction ?? 'desc');
        } else {
            $query->orderBy('is_pinned', 'desc')->orderBy('created_at', 'desc');
        }

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
