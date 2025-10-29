<?php

namespace App\Actions\GroupPosts;

use App\Data\GroupPost\GroupPostRelationIndexData;
use App\Models\GroupPost;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupPostLikes
{
    use AsAction;

    public function handle(GroupPost $groupPost, GroupPostRelationIndexData $data): LengthAwarePaginator
    {
        return $groupPost->likes()
            ->with(['user'])
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
