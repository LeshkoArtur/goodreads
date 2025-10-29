<?php

namespace App\Actions\GroupPolls;

use App\Data\GroupPoll\GroupPollIndexData;
use App\Models\GroupPoll;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupPolls
{
    use AsAction;

    public function handle(GroupPollIndexData $data): LengthAwarePaginator
    {
        $searchQuery = GroupPoll::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        if (in_array($data->sort, ['question', 'created_at'])) {
            $searchQuery->orderBy($data->sort, $data->direction ?? 'desc');
        }

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/group-polls');

        return $paginator;
    }

    private function applyFilters(Builder $query, GroupPollIndexData $data): void
    {
        $filters = collect()
                ->when($data->group_id, fn ($collection) => $collection->push("group_id = '{$data->group_id}'"))
                ->when($data->creator_id, fn ($collection) => $collection->push("creator_id = '{$data->creator_id}'"))
                ->when($data->is_active !== null, fn ($collection) => $collection->push('is_active = '.($data->is_active ? 'true' : 'false')))
                ;

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
