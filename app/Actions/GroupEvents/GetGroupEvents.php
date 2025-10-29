<?php

namespace App\Actions\GroupEvents;

use App\Data\GroupEvent\GroupEventIndexData;
use App\Models\GroupEvent;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupEvents
{
    use AsAction;

    public function handle(GroupEventIndexData $data): LengthAwarePaginator
    {
        $searchQuery = GroupEvent::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        if (in_array($data->sort, ['title', 'event_date', 'created_at'])) {
            $searchQuery->orderBy($data->sort, $data->direction ?? 'desc');
        }

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/group-events');

        return $paginator;
    }

    private function applyFilters(Builder $query, GroupEventIndexData $data): void
    {
        $filters = collect()
                ->when($data->group_id, fn ($collection) => $collection->push("group_id = '{$data->group_id}'"))
                ->when($data->creator_id, fn ($collection) => $collection->push("creator_id = '{$data->creator_id}'"))
                ->when($data->status, fn ($collection) => $collection->push("status = '{$data->status->value}'"))
                ->when($data->location, fn ($collection) => $collection->push("location = '{$data->location}'"))
                ->when($data->min_event_date, fn ($collection) => $collection->push("event_date >= '{$data->min_event_date}'"))
                ->when($data->max_event_date, fn ($collection) => $collection->push("event_date <= '{$data->max_event_date}'"))
                ;

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
