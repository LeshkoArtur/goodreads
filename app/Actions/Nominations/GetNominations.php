<?php

namespace App\Actions\Nominations;

use App\Data\Nomination\NominationIndexData;
use App\Models\Nomination;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetNominations
{
    use AsAction;

    public function handle(NominationIndexData $data): LengthAwarePaginator
    {
        $searchQuery = Nomination::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        if ($data->sort === 'created_at') {
            $searchQuery->orderBy($data->sort, $data->direction ?? 'desc');
        }

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/nominations');

        return $paginator;
    }

    private function applyFilters(Builder $query, NominationIndexData $data): void
    {
        $filters = collect()
                ->when($data->award_id, fn ($collection) => $collection->push("award_id = '{$data->award_id}'"))
                ;

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
