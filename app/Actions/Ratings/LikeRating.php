<?php

namespace App\Actions\Ratings;

use App\Models\Like;
use App\Models\Rating;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class LikeRating
{
    use AsAction;

    public function handle(Rating $rating, User $user): bool
    {
        if ($rating->likes()->where('user_id', $user->id)->exists()) {
            return false;
        }

        Like::create([
            'user_id' => $user->id,
            'likeable_type' => Rating::class,
            'likeable_id' => $rating->id,
        ]);

        return true;
    }
}
