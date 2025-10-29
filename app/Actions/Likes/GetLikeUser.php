<?php

namespace App\Actions\Likes;

use App\Models\Like;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class GetLikeUser
{
    use AsAction;

    public function handle(Like $like): User
    {
        return $like->user;
    }
}
