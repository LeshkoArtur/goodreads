<?php

namespace App\Actions\PollOptions;

use App\Data\PollOption\PollOptionIndexData;
use App\Models\PollOption;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPollOptions
{
    use AsAction;

    public function handle(PollOptionIndexData $data): LengthAwarePaginator
    {
        $searchQuery = PollOption::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        if (in_array($data->sort, ['created_at', 'vote_count'])) {
            $searchQuery->orderBy($data->sort, $data->direction ?? 'desc');
        }

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/poll-options');

        return $paginator;
    }

    private function applyFilters(Builder $query, PollOptionIndexData $data): void
    {
        $filters = collect()
                ->when($data->group_poll_id, fn ($collection) => $collection->push("group_poll_id = '{$data->group_poll_id}'"))
                ;

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
