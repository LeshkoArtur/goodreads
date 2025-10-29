<?php

namespace App\Actions\Likes;

use App\Data\Like\LikeUpdateData;
use App\Models\Like;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateLike
{
    use AsAction;

    public function handle(Like $like, LikeUpdateData $data): Like
    {
        $like->update(array_filter([
            'user_id' => $data->user_id,
            'likeable_id' => $data->likeable_id,
            'likeable_type' => $data->likeable_type,
        ], fn ($value) => $value !== null));

        return $like->fresh(['user', 'likeable']);
    }
}
