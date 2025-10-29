<?php

namespace App\Actions\Publishers;

use App\Data\Publisher\PublisherIndexData;
use App\Models\Publisher;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPublishers
{
    use AsAction;

    public function handle(PublisherIndexData $data): LengthAwarePaginator
    {
        $searchQuery = Publisher::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        if (in_array($data->sort, ['created_at', 'founded_year'])) {
            $searchQuery->orderBy($data->sort, $data->direction ?? 'desc');
        }

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/publishers');

        return $paginator;
    }

    private function applyFilters(Builder $query, PublisherIndexData $data): void
    {
        $filters = collect()
            ->when($data->country, fn ($collection) => $collection->push("country = '{$data->country}'"))
            ->when($data->min_founded_year !== null, fn ($collection) => $collection->push("founded_year >= {$data->min_founded_year}"))
            ->when($data->max_founded_year !== null, fn ($collection) => $collection->push("founded_year <= {$data->max_founded_year}"));

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
