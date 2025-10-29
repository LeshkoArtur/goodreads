<?php

namespace App\Actions\Collections;

use App\Data\Collection\CollectionIndexData;
use App\Models\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCollections
{
    use AsAction;

    public function handle(CollectionIndexData $data): LengthAwarePaginator
    {
        $searchQuery = Collection::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        when(
            in_array($data->sort, ['title', 'created_at']),
            fn () => $searchQuery->orderBy($data->sort, $data->direction ?? 'desc')
        );

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/collections');

        return $paginator;
    }

    private function applyFilters(Builder $query, CollectionIndexData $data): void
    {
        $filters = collect()
                ->when($data->user_id, fn ($collection) => $collection->push("user_id = '{$data->user_id}'"))
                ->when($data->is_public !== null, fn ($collection) => $collection->push('is_public = '.($data->is_public ? 'true' : 'false')))
                ->when($data->book_ids, fn ($collection) => $collection->push('book_ids IN ['.collect($data->book_ids)->implode(',').']'))
                ;

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
