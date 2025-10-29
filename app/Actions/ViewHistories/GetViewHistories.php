<?php

namespace App\Actions\ViewHistories;

use App\Data\ViewHistory\ViewHistoryIndexData;
use App\Models\ViewHistory;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetViewHistories
{
    use AsAction;

    public function handle(ViewHistoryIndexData $data): LengthAwarePaginator
    {
        $searchQuery = ViewHistory::search('');

        $this->applyFilters($searchQuery, $data);

        when(
            in_array($data->sort, ['created_at']),
            fn () => $searchQuery->orderBy($data->sort, $data->direction ?? 'desc')
        );

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/view-histories');

        return $paginator;
    }

    private function applyFilters(Builder $query, ViewHistoryIndexData $data): void
    {
        $filters = collect()
            ->when($data->user_id, fn ($collection) => $collection->push("user_id = '{$data->user_id}'"))
            ->when($data->viewable_type, fn ($collection) => $collection->push("viewable_type = '{$data->viewable_type}'"))
            ->when($data->viewable_id, fn ($collection) => $collection->push("viewable_id = '{$data->viewable_id}'"));

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
