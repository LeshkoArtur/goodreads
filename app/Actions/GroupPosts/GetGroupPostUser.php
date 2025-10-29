<?php

namespace App\Actions\GroupPosts;

use App\Models\GroupPost;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupPostUser
{
    use AsAction;

    public function handle(GroupPost $groupPost): User
    {
        return $groupPost->user;
    }
}
