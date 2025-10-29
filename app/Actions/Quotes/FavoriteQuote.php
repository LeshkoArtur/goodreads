<?php

namespace App\Actions\Quotes;

use App\Models\Favorite;
use App\Models\Quote;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class FavoriteQuote
{
    use AsAction;

    public function handle(Quote $quote, User $user): bool
    {
        if ($quote->favorites()->where('user_id', $user->id)->exists()) {
            return false;
        }

        Favorite::create([
            'user_id' => $user->id,
            'favoriteable_type' => Quote::class,
            'favoriteable_id' => $quote->id,
        ]);

        return true;
    }
}
