<?php

namespace App\Actions\GroupModerationLogs;

use App\Data\GroupModerationLog\GroupModerationLogIndexData;
use App\Models\GroupModerationLog;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupModerationLogs
{
    use AsAction;

    public function handle(GroupModerationLogIndexData $data): LengthAwarePaginator
    {
        $searchQuery = GroupModerationLog::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        if (in_array($data->sort, ['created_at', 'action'])) {
            $searchQuery->orderBy($data->sort, $data->direction ?? 'desc');
        }

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/group-moderation-logs');

        return $paginator;
    }

    private function applyFilters(Builder $query, GroupModerationLogIndexData $data): void
    {
        $filters = collect()
                ->when($data->group_id, fn ($collection) => $collection->push("group_id = '{$data->group_id}'"))
                ->when($data->moderator_id, fn ($collection) => $collection->push("moderator_id = '{$data->moderator_id}'"))
                ->when($data->action, fn ($collection) => $collection->push("action = '{$data->action->value}'"))
                ->when($data->targetable_type, fn ($collection) => $collection->push("targetable_type = '{$data->targetable_type}'"))
                ->when($data->targetable_id, fn ($collection) => $collection->push("targetable_id = '{$data->targetable_id}'"))
                ;

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
