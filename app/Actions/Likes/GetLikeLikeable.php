<?php

namespace App\Actions\Likes;

use App\Models\Like;
use Illuminate\Database\Eloquent\Model;
use Lorisleiva\Actions\Concerns\AsAction;

class GetLikeLikeable
{
    use AsAction;

    public function handle(Like $like): ?Model
    {
        return $like->likeable;
    }
}
