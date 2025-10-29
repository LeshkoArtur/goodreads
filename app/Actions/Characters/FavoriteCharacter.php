<?php

namespace App\Actions\Characters;

use App\Models\Character;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class FavoriteCharacter
{
    use AsAction;

    public function handle(Character $character, User $user): bool
    {
        return $user->favorites()->firstOrCreate([
            'favoritable_type' => Character::class,
            'favoritable_id' => $character->id,
        ]) !== null;
    }
}
