<?php

namespace App\Actions\Ratings;

use App\Models\Rating;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class UnlikeRating
{
    use AsAction;

    public function handle(Rating $rating, User $user): bool
    {
        $like = $rating->likes()->where('user_id', $user->id)->first();

        if (! $like) {
            return false;
        }

        $like->delete();

        return true;
    }
}
