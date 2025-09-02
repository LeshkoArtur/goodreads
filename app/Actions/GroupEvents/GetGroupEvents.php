<?php

namespace App\Actions\GroupEvents;

use App\DTOs\GroupEvent\GroupEventIndexDTO;
use App\Models\GroupEvent;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetGroupEvents
{
    use AsAction;

    /**
     * Отримати список подій груп із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param GroupEventIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(GroupEventIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = GroupEvent::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['title', 'event_date', 'created_at'])) {
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
     * @param GroupEventIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, GroupEventIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->groupId) {
                $options['filter'][] = "group_id = '{$dto->groupId}'";
            }

            if ($dto->creatorId) {
                $options['filter'][] = "creator_id = '{$dto->creatorId}'";
            }

            if ($dto->status) {
                $options['filter'][] = "status = '{$dto->status}'";
            }

            if ($dto->minEventDate) {
                $options['filter'][] = "event_date >= '{$dto->minEventDate}'";
            }

            if ($dto->maxEventDate) {
                $options['filter'][] = "event_date <= '{$dto->maxEventDate}'";
            }

            if ($dto->location) {
                $options['filter'][] = "location = '{$dto->location}'";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
