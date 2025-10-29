<?php

namespace App\Actions\Quotes;

use App\Models\Like;
use App\Models\Quote;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class LikeQuote
{
    use AsAction;

    public function handle(Quote $quote, User $user): bool
    {
        if ($quote->likes()->where('user_id', $user->id)->exists()) {
            return false;
        }

        Like::create([
            'user_id' => $user->id,
            'likeable_type' => Quote::class,
            'likeable_id' => $quote->id,
        ]);

        return true;
    }
}
