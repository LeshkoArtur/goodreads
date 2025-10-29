<?php

namespace App\Actions\Awards;

use App\Data\Award\AwardRelationIndexData;
use App\Models\Award;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAwardWinners
{
    use AsAction;

    public function handle(Award $award, AwardRelationIndexData $data): LengthAwarePaginator
    {
        return $award->nominations()
            ->where('is_winner', true)
            ->with(['book', 'category'])
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
