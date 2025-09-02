<?php

namespace App\Actions\GroupPolls;

use App\DTOs\GroupPoll\GroupPollIndexDTO;
use App\Models\GroupPoll;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetGroupPolls
{
    use AsAction;

    /**
     * Отримати список опитувань груп із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param GroupPollIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(GroupPollIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = GroupPoll::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['question', 'created_at'])) {
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
     * @param GroupPollIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, GroupPollIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->groupId) {
                $options['filter'][] = "group_id = '{$dto->groupId}'";
            }

            if ($dto->creatorId) {
                $options['filter'][] = "creator_id = '{$dto->creatorId}'";
            }

            if ($dto->isActive !== null) {
                $options['filter'][] = "is_active = " . ($dto->isActive ? 'true' : 'false');
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
