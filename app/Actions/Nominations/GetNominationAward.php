<?php

namespace App\Actions\Nominations;

use App\Models\Award;
use App\Models\Nomination;
use Lorisleiva\Actions\Concerns\AsAction;

class GetNominationAward
{
    use AsAction;

    public function handle(Nomination $nomination): Award
    {
        return $nomination->award;
    }
}
