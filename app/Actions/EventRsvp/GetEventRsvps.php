<?php

namespace App\Actions\EventRsvps;

use App\DTOs\EventRsvp\EventRsvpIndexDTO;
use App\Models\EventRsvp;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetEventRsvps
{
    use AsAction;

    /**
     * Отримати список RSVP на події з пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param EventRsvpIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(EventRsvpIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = EventRsvp::search($dto->query ?? '');

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
     * @param EventRsvpIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, EventRsvpIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->groupEventId) {
                $options['filter'][] = "group_event_id = '{$dto->groupEventId}'";
            }

            if ($dto->userId) {
                $options['filter'][] = "user_id = '{$dto->userId}'";
            }

            if ($dto->response) {
                $options['filter'][] = "response = '{$dto->response}'";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
