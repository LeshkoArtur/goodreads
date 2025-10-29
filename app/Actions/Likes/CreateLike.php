<?php

namespace App\Actions\Likes;

use App\Data\Like\LikeStoreData;
use App\Models\Like;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateLike
{
    use AsAction;

    public function handle(LikeStoreData $data, User $user): Like
    {
        $like = new Like;
        $like->user_id = $user->id;
        $like->likeable_type = $data->likeable_type;
        $like->likeable_id = $data->likeable_id;
        $like->save();

        return $like->fresh(['user', 'likeable']);
    }
}
