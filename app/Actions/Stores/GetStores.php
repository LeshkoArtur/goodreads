<?php

namespace App\Actions\Stores;

use App\Data\Store\StoreIndexData;
use App\Models\Store;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetStores
{
    use AsAction;

    public function handle(StoreIndexData $data): LengthAwarePaginator
    {
        $searchQuery = Store::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        when(
            in_array($data->sort, ['created_at', 'name']),
            fn () => $searchQuery->orderBy($data->sort, $data->direction ?? 'desc')
        );

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/stores');

        return $paginator;
    }

    private function applyFilters(Builder $query, StoreIndexData $data): void
    {
        $filters = collect()
            ->when($data->region, fn ($collection) => $collection->push("region = '{$data->region}'"));

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
