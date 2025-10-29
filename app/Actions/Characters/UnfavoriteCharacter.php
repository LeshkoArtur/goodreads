<?php

namespace App\Actions\Characters;

use App\Models\Character;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class UnfavoriteCharacter
{
    use AsAction;

    public function handle(Character $character, User $user): bool
    {
        return $user->favorites()
            ->where('favoritable_type', Character::class)
            ->where('favoritable_id', $character->id)
            ->delete() > 0;
    }
}
