<?php

namespace App\Actions\Quotes;

use App\Models\Quote;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class UnfavoriteQuote
{
    use AsAction;

    public function handle(Quote $quote, User $user): bool
    {
        $favorite = $quote->favorites()->where('user_id', $user->id)->first();

        if (! $favorite) {
            return false;
        }

        $favorite->delete();

        return true;
    }
}
