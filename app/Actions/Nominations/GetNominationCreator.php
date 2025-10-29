<?php

namespace App\Actions\Nominations;

use App\Models\Nomination;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class GetNominationCreator
{
    use AsAction;

    public function handle(Nomination $nomination): ?User
    {
        return $nomination->creator ?? null;
    }
}
