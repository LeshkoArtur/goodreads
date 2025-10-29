<?php

namespace App\Actions\Shelves;

use App\Data\Shelf\ShelfIndexData;
use App\Models\Shelf;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetShelves
{
    use AsAction;

    public function handle(ShelfIndexData $data): LengthAwarePaginator
    {
        $searchQuery = Shelf::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        when(
            in_array($data->sort, ['created_at', 'name']),
            fn () => $searchQuery->orderBy($data->sort, $data->direction ?? 'desc')
        );

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/shelves');

        return $paginator;
    }

    private function applyFilters(Builder $query, ShelfIndexData $data): void
    {
        $filters = collect()
            ->when($data->user_id, fn ($collection) => $collection->push("user_id = '{$data->user_id}'"));

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
