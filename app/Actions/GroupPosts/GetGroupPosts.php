<?php

namespace App\Actions\GroupPosts;

use App\Data\GroupPost\GroupPostIndexData;
use App\Models\GroupPost;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupPosts
{
    use AsAction;

    public function handle(GroupPostIndexData $data): LengthAwarePaginator
    {
        $searchQuery = GroupPost::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        if ($data->sort === 'created_at') {
            $searchQuery->orderBy($data->sort, $data->direction ?? 'desc');
        }

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/group-posts');

        return $paginator;
    }

    private function applyFilters(Builder $query, GroupPostIndexData $data): void
    {
        $filters = collect()
                ->when($data->group_id, fn ($collection) => $collection->push("group_id = '{$data->group_id}'"))
                ->when($data->user_id, fn ($collection) => $collection->push("user_id = '{$data->user_id}'"))
                ->when($data->is_pinned !== null, fn ($collection) => $collection->push('is_pinned = '.($data->is_pinned ? 'true' : 'false')))
                ->when($data->category, fn ($collection) => $collection->push("category = '{$data->category->value}'"))
                ->when($data->post_status, fn ($collection) => $collection->push("post_status = '{$data->post_status->value}'"))
                ;

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
