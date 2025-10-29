<?php

namespace App\Actions\GroupPosts;

use App\Models\GroupPost;
use Lorisleiva\Actions\Concerns\AsAction;

class PinGroupPost
{
    use AsAction;

    public function handle(GroupPost $groupPost): bool
    {
        if ($groupPost->is_pinned) {
            return false;
        }

        $groupPost->is_pinned = true;
        $groupPost->save();

        return true;
    }
}
