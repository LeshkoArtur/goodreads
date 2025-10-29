<?php

namespace App\Actions\GroupPosts;

use App\Data\GroupPost\GroupPostStoreData;
use App\Models\GroupPost;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateGroupPost
{
    use AsAction;

    public function handle(GroupPostStoreData $data, User $user): GroupPost
    {
        $groupPost = new GroupPost;
        $groupPost->group_id = $data->group_id;
        $groupPost->user_id = $user->id;
        $groupPost->content = $data->content;
        $groupPost->is_pinned = $data->is_pinned ?? false;
        $groupPost->category = $data->category;
        $groupPost->post_status = $data->post_status;
        $groupPost->save();

        return $groupPost->fresh(['group', 'user']);
    }
}
