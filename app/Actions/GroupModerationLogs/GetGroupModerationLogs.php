<?php

namespace App\Actions\GroupModerationLogs;

use App\DTOs\GroupModerationLog\GroupModerationLogIndexDTO;
use App\Models\GroupModerationLog;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetGroupModerationLogs
{
    use AsAction;

    /**
     * Отримати список логів модерації груп із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param GroupModerationLogIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(GroupModerationLogIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = GroupModerationLog::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['created_at', 'action'])) {
            $searchQuery->orderBy($dto->sort, $dto->direction ?? 'desc');
        }

        return $searchQuery->paginate(
            perPage: $dto->perPage,
            page: $dto->page
        );
    }

    /**
     * Застосувати фільтри до пошукового запиту Meilisearch.
     *
     * @param Builder $query
     * @param GroupModerationLogIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, GroupModerationLogIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->groupId) {
                $options['filter'][] = "group_id = '{$dto->groupId}'";
            }

            if ($dto->moderatorId) {
                $options['filter'][] = "moderator_id = '{$dto->moderatorId}'";
            }

            if ($dto->action) {
                $options['filter'][] = "action = '{$dto->action}'";
            }

            if ($dto->targetableType) {
                $options['filter'][] = "targetable_type = '{$dto->targetableType}'";
            }

            if ($dto->targetableId) {
                $options['filter'][] = "targetable_id = '{$dto->targetableId}'";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
