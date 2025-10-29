<?php

namespace App\Actions\Nominations;

use App\Data\Nomination\NominationUpdateData;
use App\Models\Nomination;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateNomination
{
    use AsAction;

    public function handle(Nomination $nomination, NominationUpdateData $data): Nomination
    {
        $nomination->name = $data->name;
        $nomination->description = $data->description;
        $nomination->save();

        return $nomination->fresh(['award']);
    }
}
