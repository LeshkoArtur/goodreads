<?php

namespace App\Actions\Nominations;

use App\Data\Nomination\NominationRelationIndexData;
use App\Models\Nomination;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetNominationEntries
{
    use AsAction;

    public function handle(Nomination $nomination, NominationRelationIndexData $data): LengthAwarePaginator
    {
        return $nomination->entries()
            ->with(['nominatable'])
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
