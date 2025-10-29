<?php

namespace App\Actions\Quotes;

use App\Models\Quote;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class UnlikeQuote
{
    use AsAction;

    public function handle(Quote $quote, User $user): bool
    {
        $like = $quote->likes()->where('user_id', $user->id)->first();

        if (! $like) {
            return false;
        }

        $like->delete();

        return true;
    }
}
