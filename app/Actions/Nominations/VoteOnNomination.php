<?php

namespace App\Actions\Nominations;

use App\Models\NominationEntry;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class VoteOnNomination
{
    use AsAction;

    public function handle(NominationEntry $entry, User $user): bool
    {
        return $entry->votes()->firstOrCreate([
            'user_id' => $user->id,
        ]) !== null;
    }
}
