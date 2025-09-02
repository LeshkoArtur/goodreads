<?php

namespace App\Actions\Likes;

use App\DTOs\Like\LikeUpdateDTO;
use App\Models\Like;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateLike
{
    use AsAction;

    /**
     * Оновити існуючий лайк.
     *
     * @param Like $like
     * @param LikeUpdateDTO $dto
     * @return Like
     */
    public function handle(Like $like, LikeUpdateDTO $dto): Like
    {
        $attributes = [
            'likeable_type' => $dto->likeableType,
            'likeable_id' => $dto->likeableId,
        ];

        $like->fill(array_filter($attributes, fn($value) => $value !== null));

        $like->save();

        return $like->load(['user', 'likeable']);
    }
}
