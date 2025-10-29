<?php

namespace App\Actions\EventRsvps;

use App\Data\EventRsvp\EventRsvpIndexData;
use App\Models\EventRsvp;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetEventRsvps
{
    use AsAction;

    public function handle(EventRsvpIndexData $data): LengthAwarePaginator
    {
        $searchQuery = EventRsvp::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        if ($data->sort === 'created_at') {
            $searchQuery->orderBy($data->sort, $data->direction ?? 'desc');
        }

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/event-rsvps');

        return $paginator;
    }

    private function applyFilters(Builder $query, EventRsvpIndexData $data): void
    {
        $filters = collect()
                ->when($data->group_event_id, fn ($collection) => $collection->push("group_event_id = '{$data->group_event_id}'"))
                ->when($data->user_id, fn ($collection) => $collection->push("user_id = '{$data->user_id}'"))
                ->when($data->response, fn ($collection) => $collection->push("response = '{$data->response->value}'"))
                ;

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
