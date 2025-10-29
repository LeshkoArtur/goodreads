<?php

namespace App\Actions\Groups;

use App\Data\Group\GroupIndexData;
use App\Models\Group;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroups
{
    use AsAction;

    public function handle(GroupIndexData $data): LengthAwarePaginator
    {
        $searchQuery = Group::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        when(
            in_array($data->sort, ['name', 'member_count', 'created_at']),
            fn () => $searchQuery->orderBy($data->sort, $data->direction ?? 'desc')
        );

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/groups');

        return $paginator;
    }

    private function applyFilters(Builder $query, GroupIndexData $data): void
    {
        $filters = collect()
                ->when($data->creator_id, fn ($collection) => $collection->push("creator_id = '{$data->creator_id}'"))
                ->when($data->is_public !== null, fn ($collection) => $collection->push('is_public = '.($data->is_public ? 'true' : 'false')))
                ->when($data->is_active !== null, fn ($collection) => $collection->push('is_active = '.($data->is_active ? 'true' : 'false')))
                ->when($data->join_policy, fn ($collection) => $collection->push("join_policy = '{$data->join_policy->value}'"))
                ->when($data->post_policy, fn ($collection) => $collection->push("post_policy = '{$data->post_policy->value}'"))
                ->when($data->min_member_count !== null, fn ($collection) => $collection->push("member_count >= {$data->min_member_count}"))
                ->when($data->max_member_count !== null, fn ($collection) => $collection->push("member_count <= {$data->max_member_count}"))
                ->when($data->member_ids, fn ($collection) => $collection->push('member_ids IN ['.collect($data->member_ids)->implode(',').']'))
                ;

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
