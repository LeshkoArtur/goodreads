<?php

namespace App\Actions\Likes;

use App\Data\Like\LikeToggleData;
use App\Models\Like;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class ToggleLike
{
    use AsAction;

    public function handle(LikeToggleData $data, User $user): array
    {
        $like = Like::where('user_id', $user->id)
            ->where('likeable_type', $data->likeable_type)
            ->where('likeable_id', $data->likeable_id)
            ->first();

        if ($like) {
            $like->delete();

            return [
                'action' => 'unliked',
                'message' => 'Лайк успішно видалено.',
            ];
        }

        $like = new Like;
        $like->user_id = $user->id;
        $like->likeable_type = $data->likeable_type;
        $like->likeable_id = $data->likeable_id;
        $like->save();

        return [
            'action' => 'liked',
            'message' => 'Успішно вподобано.',
            'like' => $like->fresh(['user', 'likeable']),
        ];
    }
}
