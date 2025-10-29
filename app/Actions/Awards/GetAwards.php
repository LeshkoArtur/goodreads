<?php

namespace App\Actions\Awards;

use App\Data\Award\AwardIndexData;
use App\Models\Award;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAwards
{
    use AsAction;

    public function handle(AwardIndexData $data): LengthAwarePaginator
    {
        $searchQuery = Award::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        if (in_array($data->sort, ['name', 'year', 'ceremony_date', 'created_at'])) {
            $searchQuery->orderBy($data->sort, $data->direction ?? 'desc');
        }

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/awards');

        return $paginator;
    }

    private function applyFilters(Builder $query, AwardIndexData $data): void
    {
        $filters = collect()
                ->when($data->year, fn ($collection) => $collection->push("year = {$data->year}"))
                ->when($data->organizer, fn ($collection) => $collection->push("organizer = '{$data->organizer}'"))
                ->when($data->country, fn ($collection) => $collection->push("country = '{$data->country}'"))
                ;

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
