<?php

namespace App\Actions\GroupPosts;

use App\Models\Group;
use App\Models\GroupPost;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupPostGroup
{
    use AsAction;

    public function handle(GroupPost $groupPost): Group
    {
        return $groupPost->group;
    }
}
