<?php

namespace App\Actions\Nominations;

use App\Data\Nomination\NominationStoreData;
use App\Models\Nomination;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNomination
{
    use AsAction;

    public function handle(NominationStoreData $data): Nomination
    {
        $nomination = new Nomination;
        $nomination->award_id = $data->award_id;
        $nomination->name = $data->name;
        $nomination->description = $data->description;
        $nomination->save();

        return $nomination->fresh(['award']);
    }
}
