<?php

namespace App\Actions\Likes;

use App\DTOs\Like\LikeStoreDTO;
use App\Models\Like;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateLike
{
    use AsAction;

    /**
     * Створити новий лайк.
     *
     * @param LikeStoreDTO $dto
     * @return Like
     */
    public function handle(LikeStoreDTO $dto): Like
    {
        $like = new Like();
        $like->user_id = $dto->userId;
        $like->likeable_id = $dto->likeableId;
        $like->likeable_type = $dto->likeableType;

        $like->save();

        return $like->load(['user', 'likeable']);
    }
}
