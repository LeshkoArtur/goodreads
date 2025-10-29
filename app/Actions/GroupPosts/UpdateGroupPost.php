<?php

namespace App\Actions\GroupPosts;

use App\Data\GroupPost\GroupPostUpdateData;
use App\Models\GroupPost;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateGroupPost
{
    use AsAction;

    public function handle(GroupPost $groupPost, GroupPostUpdateData $data): GroupPost
    {
        $groupPost->content = $data->content;

        if ($data->is_pinned !== null) {
            $groupPost->is_pinned = $data->is_pinned;
        }

        if ($data->category !== null) {
            $groupPost->category = $data->category;
        }

        if ($data->post_status !== null) {
            $groupPost->post_status = $data->post_status;
        }

        $groupPost->save();

        return $groupPost->fresh(['group', 'user']);
    }
}
