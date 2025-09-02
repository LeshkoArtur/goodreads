<?php

namespace App\Actions\ViewHistories;

use App\DTOs\ViewHistory\ViewHistoryIndexDTO;
use App\Models\ViewHistory;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetViewHistories
{
    use AsAction;

    /**
     * Отримати список історії переглядів із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param ViewHistoryIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(ViewHistoryIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = ViewHistory::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['created_at'])) {
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
     * @param ViewHistoryIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, ViewHistoryIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->userId) {
                $options['filter'][] = "user_id = {$dto->userId}";
            }

            if ($dto->viewableType) {
                $options['filter'][] = "viewable_type = '{$dto->viewableType}'";
            }

            if ($dto->viewableId) {
                $options['filter'][] = "viewable_id = {$dto->viewableId}";
            }

            if ($dto->minViewedAt) {
                $options['filter'][] = "created_at >= {$dto->minViewedAt}";
            }

            if ($dto->maxViewedAt) {
                $options['filter'][] = "created_at <= {$dto->maxViewedAt}";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
